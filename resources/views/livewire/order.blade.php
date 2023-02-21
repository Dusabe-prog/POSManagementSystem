<div class="col-lg-12">
    <div class="row">
        <div class="col-md-8">
            <div class="card">



                <div class="card-header">
                    <h4 style="float:left;">Order Products</h4>
                    <a href="" style="float:right" class="btn btn-dark" data-toggle="modal"
                        data-target="#addproduct">
                        <i class="fa fa-plus"></i> Add New Product</a>
                </div>
                {{-- <form action="{{ route('orders.store') }}" method="POST">
                    @csrf --}}
                <div class="card-body">
                    <div class="my-3 mx-3">
                        <form wire:submit.prevent="insertoCart">
                            <input type="text" name="" id="" wire:model="product_code"
                                class="form-control" placeholder="Enter product code">
                        </form>
                    </div>
                    <div class="alert alert-success"> {{ $message }}</div>


                    <table class="table table-bordered table-left">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Dis (%)</th>
                                <th colspan="6">Total</th>
                                {{-- <th>
                                    <a href="#" class="btn btn-sm btn-success add_more">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </th> --}}
                            </tr>
                        </thead>
                        <tbody class="addMoreProduct">
                            @foreach ($productIncart as $key => $cart)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td width="30%">
                                        <input type="text" value="{{ $cart->product->product_name }}" name=""
                                            id="" class="form-control">
                                    </td>
                                    <td><input type="number" name="quantity[]" id="quantity"
                                            class="form-control quantity" value="{{ $cart->product_qty }}"></td>
                                    <td><input type="number" name="price[]" id="price" class="form-control price"
                                            value="{{ $cart->product->price }}">
                                    </td>
                                    <td><input type="number" name="discount[]" id="discount"
                                            class="form-control discount"></td>
                                    <td><input type="number" name="total_amount[]" id="total_amount"
                                            class="form-control total_amount"
                                            value="{{ $cart->product_qty * $cart->product->price }}"></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger">
                                            <i class="fa fa-times" wire:click="removeProduct({{ $cart->id }})"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4> Total <b class="total"> 0.00 </b></h4>
                </div>
                <div class="card-body">
                    <div class="btn-group">
                        <button type="button" onclick="PrintReceiptContent('print');" class="btn btn-dark">
                            <i class=" fa fa-print"></i> Print
                        </button>
                        <button type="button" onclick="" class="btn btn-primary">
                            <i class=" fa fa-print"></i> Hidtory
                        </button>
                        <button type="button" onclick="" class="btn btn-danger">
                            <i class=" fa fa-print"></i> Report
                        </button>
                    </div>
                    <div class="panel">
                        <div class="row">
                            <table class="table table-striped">
                                <tr>
                                    <td>
                                        <label for="">Custom Name</label>
                                        <input type="text" name="customer_name" id="" class="form-control">
                                    </td>
                                    <td>
                                        <label for="">Custom Phone</label>
                                        <input type="number" name="customer_phone" id="" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Payment Method <br></td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="radio-item">
                                            <input type="radio" name="payment_method" id="payment_method"
                                                class="true" value="cash" checked="checked">
                                            <label for="payment_method"><i class="fa fa-money-bill text-success"></i>
                                                Cash</label>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="radio-item">
                                            <input type="radio" name="payment_method" id="payment_method"
                                                class="true" value="bank transfert">
                                            <label for="payment_method"><i class="fa fa-university text-danger"></i>
                                                Bank Transfert</label>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="radio-item">
                                            <input type="radio" name="payment_method" id="payment_method"
                                                class="true" value="credit card">
                                            <label for="payment_method"><i class="fa fa-credit-card text-info"></i>
                                                Credit Card</label>
                                        </span>
                                    </td> <br>
                                </tr>
                            </table>
                            <td>Payment <input type="number" name="paid_amount" id="paid_amount"
                                    class="form-control"></td>
                            <td>Returning change <input type="number" readonly name="balance" id="balance"
                                    class="form-control"></td>
                            <td>
                                <button class="btn btn-primary btn-lg btn-block mt-3">Save</button>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-lg btn-block mt-2">Calculate</button>
                            </td>
                            <div class="text-center"><a href="#"
                                    class="btn btn-white btn-lg btn-block text-danger"><i
                                        class="fa fa-sign-out-alt"></i> Logout</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
