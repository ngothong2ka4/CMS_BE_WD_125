<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AdsService;
use App\Models\ConfigAds;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdsServiceController extends Controller
{
    public function createPaymentUrl($res)
    {
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURNURL');
        $vnp_TmnCode = env('VNP_TMNCODE');
        $vnp_HashSecret = env('VNP_HASHSECRET');

        $vnp_TxnRef = $res['id'];
        $vnp_OrderType = "Shine Shop";
        $vnp_Amount = $res['price'] * 100;
        $vnp_Locale = "vn";
        $vnp_BankCode = "VNBANK";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];


        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_OrderInfo" => "Thanh toán dịch vụ:" . $vnp_TxnRef,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);

        $query = "";
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            $hashdata .= urlencode($key) . "=" . urlencode($value) . '&';
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $hashdata = rtrim($hashdata, '&');
        $query = rtrim($query, '&');

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= "?" . $query . '&vnp_SecureHash=' . $vnpSecureHash;
        }

        \Log::info('Hash Data: ' . $hashdata);
        \Log::info('Secure Hash: ' . $vnpSecureHash);
        \Log::info('Payment URL: ' . $vnp_Url);

        return $vnp_Url;
    }

    public function paymentResult(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập!', false);
        }
        $adsId = $request->input('vnp_TxnRef');
        $adsUser = AdsService::where('id_user', $user->id)->orderBy('created_at', 'desc')
                ->first();
        \Log::debug('Service ID from vnp_TxnRef: ' . $adsId);
        $ads = AdsService::find($adsId);

        if (!$ads || $adsUser->id != $adsId) {
            \Log::error('Service not found with ID: ' . $adsId);
            return $this->jsonResponse(message: 'Dịch vụ không tồn tại');
        }
        $email = $ads->email;
        if ($request->input('vnp_ResponseCode') == '00') {
            $ads->update(['status_payment'=> 2, 'status'=>1]);
            Mail::send(
                'emails.ads-service',
                compact('ads'),
                function ($message) use ($email) {
                    $message->from(config('mail.from.address'), 'Shine');
                    $message->to($email);
                    $message->subject('Thông tin dịch vụ');
                }
            );

            \Log::info("Thanh toán thành công cho dịch vụ ID: " . $adsId);
            return $this->jsonResponse('Thanh toán thành công!', true);
        } else {

            $ads->delete();
            \Log::warning("Thanh toán thất bại cho dịch vụ ID: " . $adsId);
            return $this->jsonResponse('Thanh toán thất bại', false, $ads);
        }
    }

    public function getStartEndPrice(array $data)
    {
        $date = Carbon::now();

        switch ($data['duration']) {
            case '1h':
                $end = $date->addHour();
                $data['price'] = $data['location'] == 1 ? 100000 : 50000;
                break;
            case '12h':
                $end = $date->addHours(12);
                $data['price'] = $data['location'] == 1 ? 100000 : 5000;
                break;
            case '1d':
                $end = $date->addDay();
                $data['price'] = $data['location'] == 1 ? 200000 : 10000;
                break;
            case '1w':
                $end = $date->addWeekday();
                $data['price'] = $data['location'] == 1 ? 300000 : 20000;
                break;
            case '1m':
                $end = $date->addMonth();
                $data['price'] = $data['location'] == 1 ? 400000 : 30000;
                break;
            case '6m':
                $end = $date->addMonths(6);
                $data['price'] = $data['location'] == 1 ? 500000 : 40000;
                break;
            default:
                $end = $date->addHour();
                $data['price'] = $data['location'] == 1 ? 600000 : 50000;
                break;
        }

        $data['end'] = $end->toDateTimeString();
        $data['start'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function addAdsService(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập!', false);
        }
        try {
            $request->validate([
                'name' => 'required|max:255|min:2|regex:/^[\p{L}\p{N}\s]+$/u',
                'phone' => 'required|regex:/^[0-9]{10,}$/',
                'email' => 'required|email',
                'location' => 'required',
                'duration' => 'required',
            ], [
                'name.required' => 'Tên khách hàng là bắt buộc.',
                'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'name.min' => 'Tên khách hàng phải có ít nhất 2 ký tự.',
                'name.regex' => 'Tên khách hàng chỉ được chứa chữ cái, số và khoảng trắng.',

                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không đúng định dạng.',

                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email phải có định dạng hợp lệ.',

                'location.required' => 'Vị trí là bắt buộc.',

                'duration.required' => 'Thời hạn là bắt buộc.',
            ]);

            $data = $this->getStartEndPrice($request->all());
            $data['id_user'] = $user->id;
            $data['status'] = 2;
            if (AdsService::where('status', 1)
                ->where('location', $request->location)
                ->first()
            ) {
                return $this->jsonResponse('Bạn chỉ được thuê 1 vị trí ', false);
            }
            if (AdsService::where('status', 1)
                ->where('id_user', $user->id)
                ->first()
            ) {
                return $this->jsonResponse('Bạn chỉ được thuê 1 vị trí', false);
            }
            $res = AdsService::create($data);
            $url = $this->createPaymentUrl($res);
            return $this->jsonResponse('Thuê thành công!', true, $url);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    public function addConfig(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập!', false);
        }
        try {
            $data = $request->validate([
                'title' => 'nullable|max:255|min:3',
                'image' => 'nullable|file|image|max:2048',
                'highlight' => 'nullable|max:255|min:3',
                'url' => 'nullable|active_url',
            ], [
                'title.required' => 'Tên khách hàng là bắt buộc.',
                'title.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'title.min' => 'Tên khách hàng phải có ít nhất 3 ký tự.',

                'highlight.required' => 'Tên khách hàng là bắt buộc.',
                'highlight.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'highlight.min' => 'Tên khách hàng phải có ít nhất 3 ký tự.',

                'url.active_url' => 'Đường dẫn không hợp lệ hoặc không còn hoạt động.',

                'image.max' => 'Hình ảnh dung lượng vượt quá 2MB.',
                'image.image' => 'Hình ảnh phải là một file ảnh hợp lệ.',
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $nameImage = $user->id . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                $image->move('img/ads', $nameImage);
                $path = 'img/ads/' . $nameImage;
            } else {
                $path = null;
            }
            $data['image'] = $path != null ? url($path) : null;
            $data['id_ads'] = $request->id;

            $config = ConfigAds::where('id_ads', $request->id)->orderBy('created_at', 'desc')
                ->take(1)
                ->select('title', 'highlight', 'url', 'image', 'id_ads')
                ->first();

            if ($config && $config['title'] == $data['title'] && $config['url'] == $data['url'] && $config['highlight'] == $data['highlight']) {
                return $this->jsonResponse('Dữ liệu không thay đổi', false);
            }
            ConfigAds::create($data);
            return $this->jsonResponse('Thành công!', true, $data);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    public function getAllConfig()
    {
        try {
            $ads = AdsService::where('status', 1)->first();
            // dd($ads);
            if ($ads) {
                $config =  $this->getConfig($ads->id) ?? 'Vị trí này còn trống';
               
                return $this->jsonResponse('Thành công!', true, $config);
            } else {
                return $this->jsonResponse('Chưa có người thuê!', false);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    public function getConfigUser()
    {
        $user = Auth::user();

        if (!$user) {
            return $this->jsonResponse('Bạn chưa đăng nhập!', false);
        }
        try {
            $ads = AdsService::where('status', 1)->where('id_user', $user->id)->first();
            if ($ads) {
                $ads['config'] = $this->getConfig($ads->id);
                return $this->jsonResponse('Thành công!', true, $ads);
            } else {
                return $this->jsonResponse('Bạn chưa đăng ký dịch vụ!', false);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }

    public function getConfig($adsId)
    {
        $config = ConfigAds::where('id_ads', $adsId)->orderBy('created_at', 'desc')
            ->select('title', 'highlight', 'url', 'image', 'id_ads')
            ->first();
        return $config;
    }

    public function visits($id)
    {
        try {
            $ads = AdsService::find($id);
            $config = $this->getConfig($ads->id);
            if($config == null || $config->url == null){
                return $this->jsonResponse('Chưa có đường dẫn', false);
            }
            $ads->increment('visits');
            return $this->jsonResponse('Truy cập thành công', true);
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            return $this->jsonResponse($exception->getMessage());
        }
    }
}
