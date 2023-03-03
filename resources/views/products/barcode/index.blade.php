@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4 style="float:left;">Products Barcodes</h4>
                        </div>
                        <div class="card-body">
                            <div id="print">
                                <div class="row">
                                    @forelse ($productsBarcode as $barcode)
                                    <div class="col-lg-4 col-md-5 col-sm-12 mt-3 text-center">
                                        <div class="card">
                                            <div class="card-body">
                                                <img src="{{ asset('product/barcodes/'. $barcode->barcode ) }}" alt="">

                                                <h4 class="text-center" style="padding:1em; margin-top: 0.5em;">{!! $barcode->product_code !!}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    @empty

                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
