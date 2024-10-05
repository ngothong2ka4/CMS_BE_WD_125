@extends('layouts.app-theme')


@push('scripts')
     
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body">

                <div class="position-relative row form-group mb-5">
                    <div class="col-md-3 text-md-right"><h3>Tên sản phẩm</h3></div>
                    <div class="col-md-9 col-xl-8 ">
                        
                            <h2>{{$product->name}}</h2>
                    </div>
                </div>
                @foreach(array_unique(array_column($product->variants->toArray(), 'id_attribute_color')) as $key => $color)

                <div class="position-relative row form-group">
                    <label for="" class="col-md-2 text-md-right col-form-label"><h4>Hình ảnh cho màu 
                        @foreach($colors as $item)
                        @if($item->id === $color)
                           {{$item->name}}
                        @endif
                        @endforeach
                        </h4>
                    </label>
                    <div class="col-md-10 col-xl-10">
                        <ul class="text-break" id="images">
                            @foreach($images as $image)
                            @if($color === $image->id_attribute_color)
                            <li class="float-left d-inline-block mr-2 mb-2" style="position: relative; width: 24%;">
                                <form action="{{route('delImage',$image->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Do you really want to delete this item?')"
                                        class="btn btn-sm btn-outline-danger border-0 position-absolute">
                                        X

                                    </button>
                                </form>
                                <div style="width: 180px; height: 180px; overflow: hidden;">
                                    <img width="100%" src="{{$image->link_image}}"
                                        alt="Image">
                                </div>
                            </li>
                            @endif
                            @endforeach
                            <li class="float-left d-inline-block mr-2 mb-2" style="width: 19%;">
                                <form method="post" enctype="multipart/form-data" action="{{route('delImage',$product->id)}}">
                                    @csrf
                                    <input type="hidden" name="id_attribute_color" value="{{$color}}">
                                    <div style="width: 180; max-height: 180px; overflow: hidden;">
                                        <img style="width: 100%; cursor: pointer;"
                                            class="thumbnail"
                                            data-toggle="tooltip" title="Click to add image" data-placement="bottom"
                                            src="admin/assets/images/add-image-icon.jpg" alt="Add Image">

                                        <input name="image" type="file" onchange="changeImg(this);this.form.submit()"
                                            accept="image/x-png,image/gif,image/jpeg"
                                            class="image form-control-file" style="display: none;">

                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                @endforeach
                <div class="position-relative row form-group mb-1">
                    <div class="col-md-9 col-xl-8 offset-md-3">
                        <a href="{{route('product_management.show',$product->id)}}" class="btn-shadow btn-hover-shine btn btn-primary">
                            <span>OK</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
  // = = = = = = = = = = = = = = = = changeImg = = = = = = = = = = = = = = = =
function changeImg(input) {
    //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        //Sự kiện file đã được load vào website
        reader.onload = function (e) {
            //Thay đổi đường dẫn ảnh
            $(input).siblings('.thumbnail').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
//Khi click #thumbnail thì cũng gọi sự kiện click #image
$(document).ready(function () {
    $('.thumbnail').click(function () {
        $(this).siblings('.image').click();
    });
});
    </script>
@endpush