@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4 style="float:left;">Products</h4>
                        <a href="" style="float:right" class="btn btn-dark" data-toggle="modal" data-target="#addproduct">
                        <i class="fa fa-plus"></i>Add New Product</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-left">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Alert Stock</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key=> $product )
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ number_format($product->price, 2) }}</td>
                                    <td>@if ($product->alert_stock >= $product->quantity)
                                        <span class="badge badge-danger"> Low Stock > {{ $product->alert_stock }}</span>
                                        @else <span class="badge badge-success"> {{ $product->alert_stock }} </span>
                                    @endif</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editproduct{{ $product->id }}"> <i class="fa fa-edit"></i> Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delproduct{{ $product->id }}"> <i class="fa fa-trash"></i> Delete</a>
                                        </div>
                                    </td>
                                </tr>
                                    <!-- Modal of editing new product -->

                                    @include('products.edit')
                                    <!-- Modal of Deleting new product -->

                                    <div class="modal right fade" id="delproduct{{ $product->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="staticBackdropLabel">Delete product </h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <p> Are you shure you want to delete this {{ $product->product_name }}</p>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-info" data-dismiss="modal"> Cancel</button>
                                                            <button type="submit" class="btn btn-danger"> Delete product</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                {{ $products->links() }}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <a href=""> <i class="fa fa-plsu"></i>Search product</a>
                    </div>
                    <div class="card-body">
                        ................
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal of adding new product -->

<div class="modal right fade" id="addproduct" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel">Add product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text" name="product_name" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Product Code</label>
                        <input type="text" name="product_code" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Brand</label>
                        <input type="text" name="brand" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="number" name="price" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Alert Stock</label>
                        <input type="number" name="alert_stock" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" id="" cols="30" rows="2" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Image</label>
                        <input  type="file" name="product_image" id="" cols="30" rows="2" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-block"> Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modal.right .modal-dialog{
        top: 0;
        right: 0;
        margin-right:19vh;
    }
    .modal.fade:not(.in).right .modal-dialog{
        -webkit-transform: translate3d(25%, 0, 0);
        transform: translate3d(25%, 0, 0);
    }
</style>

@endSection
