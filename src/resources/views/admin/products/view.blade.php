@extends('admin.products.index')
@section('title')
<title>Live Products</title>
@endsection

@section('links')


<a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="/product/edit/{{$product->id}}"><i class="fas fa-pen fa-sm text-white-50"></i> Edit</a>

<a class="pause d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="" data-toggle="modal" data-target="#updateModal">
    @if ($product->live == 1)
    <i class="fas fa-pause"></i> Pause
    @else
    <i class="fas fa-play"></i> Make live
    @endif
</a>
@endsection

<!-- Content Wrapper -->





@section('view')
<style>
    .productHeader {
        display: none;
    }

    .productDiv h6 {
        text-transform: uppercase;
        font-size: .7rem;
    }

    .productDiv div {
        padding: .5rem;
    }

    .productDiv p {
        color: #333;
    }
</style>


<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($product->live == 0)
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to make item live?</h5>
                @else
                <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to make item pause?</h5>
                @endif
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="" onclick="event.preventDefault();
                        document.getElementById('update-form').submit();">
                    Update</a>
                <form id="update-form" action="/product/status" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <input type="number" hidden name="id" value="{{$product->id}}">
                </form>
            </div>
        </div>
    </div>
</div>



<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">View Product</h6>
        </div>
        <div class="row productDiv" style="padding: 2rem;">
            <div class="col-6">
                <h6>Main Category</h6>
                <p>{{$product->mainCategory->name}}</p>
            </div>

            <div class="col-6">
                <h6>Sub Category</h6>
                <p>{{$product->subCategory->name}}</p>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12">
                <h6>Title</h6>
                <p>{{$product->title}}</p>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12">
                <h6>Breif description</h6>
                <p>{!!$product->brief_description!!}</p>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <!--
            <div class="col-12">
                <h6>specification</h6>
                <p>{!!$product->specifications!!}</p>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12">
                <h6>features</h6>
                <p>{!!$product->features!!}</p>
            </div>
            <div class="col-12">
                <hr>
            </div>
            -->
            <div class="col-12">
                <h6>Images</h6>
                <div class="row">
                    @foreach ($product->images as $key => $image)
                    <div class="col-3 text-center">
                        <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="" style="width: 100%;">
                    </div>
                    @endforeach
                </div>

            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-6">
                <h6>SKU</h6>
                <p>{{$product->barcode}}</p>
            </div>
            <div class="col-6">
                <h6>Brand</h6>
                <p>{{$product->brand}}</p>
            </div>
            <div class="col-6">
                <h6>Initial price (<span>&#8358;</span>)</h6>
                <p>{{$product->initial_price}}</p>
            </div>
            <div class="col-6">
                <h6>Discount (%)</h6>
                <p>{{$product->discount}}</p>
            </div>
            <div class="col-6">
                <h6>Quantity</h6>
                <p>{{$product->quantity}}</p>
            </div>
            <div class="col-6">
                <h6>total (<span>&#8358;</span>)</h6>
                <p>{{$product->total_price}}</p>
            </div>
            <div class="col-6">
                <h6>returns</h6>
                <p>{{$product->returns}}</p>
            </div>
            <div class="col-6">
                <h6>Delivery</h6>
                <p>{{$product->delivery}}</p>
            </div>
        </div>
    </div>

</div>

@endsection