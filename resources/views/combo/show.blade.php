@extends('layouts.app-theme')


@push('scripts')
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cập nhật Combo</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('combo.update',$combos->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="form-label">Tên combo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{$combos->name}}" disabled>
                        </div>
                        <div class="d-flex my-3">
                            <label for="basiInput" class="form-label">Chọn sản phẩm </label>
                            <div class="mx-3">
                                <select id="id_product" name="id_product[]" class="form-control" disabled multiple="multiple" style="width: 100%;">
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" 
                                        {{ in_array($product->id, $selectedProductIds) ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Giá</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                name="price" value="{{$combos->price}}" disabled>
                        </div>
                        <div>
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" id="" class="form-control" cols="30" rows="2" disabled>{{$combos->description}}</textarea>
                            {{-- <input type="text" class="form-control @error('description') is-invalid @enderror" 
                                name="" value=""> --}}
                        </div>
                        <div>
                            <label class="form-label">Số lượng</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                name="quantity" value="{{$combos->quantity}}" disabled>
                        </div>
                        <div class="mt-3">
                            {{-- <button type="submit" class="btn btn-success">Gửi</button> --}}
                            <a href="{{route('combo.index')}}" class="btn btn-success">Quay lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--end col-->
    </div>
@endsection

@push('scripts')
@endpush
