<?php

namespace App\Http\Controllers\Ads;

use App\Http\Controllers\Controller;
use App\Models\AdsService;
use App\Models\ConfigAds;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        if ($request->status) {
            $status = $request->status;
            $adss = AdsService::where('status', $status)->orderBy('id', 'desc')->get();
        } else {
            $adss = AdsService::where('status', 1)->orderBy('id', 'desc')->get();
        }
        return view('ads.index', compact('adss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255|min:2|regex:/^[\p{L}\p{N}\s]+$/u',
                'phone' => 'required|regex:/^[0-9]{10,}$/',
                'email' => 'required|email',
                // 'location' => 'required',
                // 'duration' => 'required',
                'price' => 'nullable|integer|min:0|max:99999999999',
                'title' => 'nullable|max:255|min:3',
                'image' => 'nullable|file|image|max:2048',
                'highlight' => 'nullable|max:255|min:3',
                'url' => 'nullable|active_url|max:255',
            ], [
                'name.required' => 'Tên khách hàng là bắt buộc.',
                'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'name.min' => 'Tên khách hàng phải có ít nhất 2 ký tự.',
                'name.regex' => 'Tên khách hàng chỉ được chứa chữ cái, số và khoảng trắng.',

                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không đúng định dạng.',

                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email phải có định dạng hợp lệ.',

                // 'location.required' => 'Vị trí là bắt buộc.',

                // 'duration.required' => 'Thời hạn là bắt buộc.',

                'price.integer' => 'Giá phải là số',
                'price.min' => 'Giá phải lớn hơn 0',
                'price.max' => 'Giá quá lớn',

                'title.required' => 'Tên khách hàng là bắt buộc.',
                'title.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'title.min' => 'Tên khách hàng phải có ít nhất 3 ký tự.',

                'highlight.required' => 'Tên khách hàng là bắt buộc.',
                'highlight.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'highlight.min' => 'Tên khách hàng phải có ít nhất 3 ký tự.',

                'url.active_url' => 'Đường dẫn không hợp lệ hoặc không còn hoạt động.',
                'url.max' => 'Đường dẫn không được vượt quá 255 ký tự.',

                'image.max' => 'Hình ảnh dung lượng vượt quá 2MB.',
                'image.image' => 'Hình ảnh phải là một file ảnh hợp lệ.',
            ]);

           $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'location' => 1,
            'duration' => $request->duration,
            'start' => null,
            'price' => $request->price,
            'id_user' => 0,
            'status_payment' => 2,
        ];
            $res = AdsService::create($this->getStartEnd($data));
           
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $nameImage = 'ads' . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                $image->move('img/ads', $nameImage);
                $path = 'img/ads/' . $nameImage;
            } else {
                $path = null;
            }

            $data_config = [ 
                'id_ads' => $res->id,
                'title' => $request->title,
                'image' => $path != null ? url($path) : null,
                'highlight' => $request->highlight,
                'url' => $request->url] ;
            
            ConfigAds::create($data_config);
            toastr()->success('Thêm mới thành công!');
            return redirect()->route('ads_service.index');
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $ads = AdsService::find($id);
        if($request->start && $request->end && $request->start > $request->end){
            toastr()->error('Khoảng thời gian không hợp lệ');
                return back();
        }
        if($request->start && $request->end){
            $start = $request->start;
            $end = $request->end;
        }else{
            $start = Carbon::parse($ads->start)->format('Y-m-d');
            $end = Carbon::now()->format('Y-m-d');
        }
       
        $visits = Visit::
        select(
            DB::raw('DATE(created_at) as time'),
            DB::raw('count(*) as visit'),
        )
        ->where('id_ads',$id)
        ->whereBetween(DB::raw('DATE(created_at)'), [$start, $end])
 
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('time')
        ->get();
    // dd($visits);
        $config = ConfigAds::where('id_ads', $id)->orderBy('created_at', 'desc')->first();
           
       

        return view('ads.show', compact('ads','config','visits','start','end'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ads = AdsService::find($id);
        $config = ConfigAds::where('id_ads', $id)->orderBy('created_at', 'desc')->first();
        return view('ads.edit', compact('ads','config'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $ads = AdsService::find($id);
            $config = ConfigAds::where('id_ads', $id)->orderBy('created_at', 'desc')->first();
            $img_old = $config->image;
            $request->validate([
                'name' => 'required|max:255|min:2|regex:/^[\p{L}\p{N}\s]+$/u',
                'phone' => 'required|regex:/^[0-9]{10,}$/',
                'email' => 'required|email',
                // 'location' => 'required',
                // 'duration' => 'required',
                'price' => 'nullable|integer|min:0|max:9999999999',
                'title' => 'nullable|max:255|min:3',
                'image' => 'nullable|file|image|max:2048',
                'highlight' => 'nullable|max:255|min:3',
                'url' => 'nullable|active_url|max:255',
            ], [
                'name.required' => 'Tên khách hàng là bắt buộc.',
                'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'name.min' => 'Tên khách hàng phải có ít nhất 2 ký tự.',
                'name.regex' => 'Tên khách hàng chỉ được chứa chữ cái, số và khoảng trắng.',

                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không đúng định dạng.',

                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email phải có định dạng hợp lệ.',

                // 'location.required' => 'Vị trí là bắt buộc.',

                // 'duration.required' => 'Thời hạn là bắt buộc.',

                'price.integer' => 'Giá phải là số',
                'price.min' => 'Giá phải lớn hơn 0',
                'price.max' => 'Giá quá lớn',

                'title.required' => 'Tên khách hàng là bắt buộc.',
                'title.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'title.min' => 'Tên khách hàng phải có ít nhất 3 ký tự.',

                'highlight.required' => 'Tên khách hàng là bắt buộc.',
                'highlight.max' => 'Tên khách hàng không được vượt quá 255 ký tự.',
                'highlight.min' => 'Tên khách hàng phải có ít nhất 3 ký tự.',

                'url.active_url' => 'Đường dẫn không hợp lệ hoặc không còn hoạt động.',
                'url.max' => 'Đường dẫn không được vượt quá 255 ký tự.',

                'image.max' => 'Hình ảnh dung lượng vượt quá 2MB.',
                'image.image' => 'Hình ảnh phải là một file ảnh hợp lệ.',
            ]);

           $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'location' => 1,
            'duration' => $request->duration,
            'price' => $request->price,
            'start' => $ads->start,
            'id_user' => 0,
            'status_payment' => 2,
        ];
            $ads->update($this->getStartEnd($data));
           
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $nameImage = 'ads' . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                $image->move('img/ads', $nameImage);
                $path = 'img/ads/' . $nameImage;

                if ($img_old && file_exists(public_path($img_old))) {
                    unlink(public_path($img_old));
                }
            } else {
                $path = $img_old;
            }

            $data_config = [ 
                'title' => $request->title,
                'image' => $path != null ? url($path) : null,
                'highlight' => $request->highlight,
                'url' => $request->url] ;
            
            $config->update($data_config);
            toastr()->success('Sửa thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $request->validate([
                'note' => 'required',
            ], [
                'note.required' => 'Ghi chú là bắt buộc.',
            ]);
            $ads = AdsService::find($id);
            $ads->update(['note'=> $request->note, 'status' => 2]);
            toastr()->success('Dịch vụ đã dừng hoạt động');
            return redirect()->back();
        } catch (\Exception $e) {
            toastr()->error('Đã có lỗi xảy ra: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function getStartEnd(array $data)
    {
        if($data['start']){
            $date =  new Carbon($data['start']);
        }else{
            $date = Carbon::now();
        }

        switch ($data['duration']) {
            case '1h':
                $end = $date->addHour();
                break;
            case '12h':
                $end = $date->addHours(12);
                break;
            case '1d':
                $end = $date->addDay();
                break;
            case '1w':
                $end = $date->addWeekday();
                break;
            case '1m':
                $end = $date->addMonth();
                break;
            case '6m':
                $end = $date->addMonths(6);
                break;
            default:
                $end = null;
                break;
        }

        $data['end'] = $end ? $end->toDateTimeString() : null;
        $data['start'] = $data['start'] ?? date('Y-m-d H:i:s');
        return $data;
    }
}
