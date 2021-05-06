@extends('layouts.site')

@section('content')
    <nav data-depth="1" class="breadcrumb-bg">
        <div class="container no-index">
            <div class="breadcrumb">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="{{route('home')}}">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>
                </ol>

            </div>
        </div>
    </nav>

    <div class="container no-index">
        <div class="row">
            <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <section id="main">
                    <h1 class="page-title">Shopping Cart</h1>
                    <div class="cart-grid row">
                        <div class="cart-grid-body col-xs-12 col-lg-9">
                            <!-- cart products detailed -->
                            <div class="cart-container">
                                <div class="cart-overview js-cart"
                                     data-refresh-url="">
                                   {{--   @isset($basket)  --}}



                                  <div class="content-wrapper">

                                    <div class="content-header">
                                      <div class="container-fluid">
                                        <br>
                                        <h3>Add Order</h3>
                                        <hr>
                                        <div class="cart-grid-right col-xs-12 col-lg-3">
                                            <div class="cart-summary">
                                                <div class="cart-detailed-totals">
                                                    <div class="cart-summary-products">
                                                        <div class="summary-label">

                                                            @if(App\Models\Product::where('inCard',1) -> count() > 0)

                                                                There are ({{ App\Models\Product::where('inCard',1) -> count() }}) items in your cart
                                                            @else
                                                                There are no items in your cart
                                                            @endif

                                                              </div>
                                                    </div>

                                                    <div class="">
                                                        <div class="cart-summary-line cart-total">
                                                            <span class="label total-price">Total:</span>


                                                        </div>

                                                    </div>

                                                </div>





                                            </div>



                                    </div>
                                    <div class="checkout text-xs-right card-block">
                                        <a href="" type="button" class="btn btn-primary"> proceed to payment
                                        </a>
                                    </div>
                                        <br>
                                        <div class="row ">
                                          <div class="col-sm-3">
                                            <h3>Products</h3>
                                          </div>
                                          <div class="col-sm-2">

                                          </div>
                                          <div class="col-sm-4">
                                            <h3></h3>
                                          </div>
                                          <div class="col-sm-3">
                                            <h3>Orders</h3>
                                          </div>
                                        </div>




                                        <div class="row mb-5">
                                          <div class="col-sm-6">

                                            <div class="card-body">
                                              <div id="accordion">
                                                <div class="card ">
                                                  @foreach ($products as $index=>$item )


                                                  <div class="card-header">
                                                    <h4 class="card-title w-140">
                                                      <a class="d-block w-140" data-toggle="collapse" href="#cat{{$index}}">
                                                      {{$item->name}}
                                                      </a>
                                                    </h4>
                                                  </div>

                                                  <div id="cat{{$index}}" class="collapse show" data-parent="#accordion">
                                                    <div class="card-body">

                                                      <table class="table table-bordered">

                                                        <thead>
                                                          <tr>


                                                            <th> photo </th>
                                                            <th ">purchase_price</th>
                                                            <th ">add</th>
                                                          </tr>
                                                        </thead>




                                                        <tbody>
                                                          <tr>


                                                              <td ><img class="img-fluid"
                                                                src="{{$item -> photo }}"
                                                                alt="Vehicula vel tempus sit amet ulte"></td>

                                                              <td >{{$item->purchase_price}} $</td>
                                                              <td ><a class="btn btn-primary btn-sm add product-{{$item->id}}
                                                                  href=" "

                                                                  data-name="{{$item->name}}"
                                                                  data-id="{{$item->id}}"
                                                                  data-price="{{$item->purchase_price}}"
                                                                 >
                                                                 <span class="fa fa-plus"></span>
                                                                </a></td>
                                                            </tr>
                                                          </tbody>


                                                        </table>
                                                    </div>
                                                  </div>
                                                  @endforeach
                                                </div>
                                              </div>
                                            </div>
                                          </div><!-- /.col -->
                                          <div class="col-sm-1">
                                          </div>

                                          <div class="col-sm-5">
                                          <br>
                                          <form action="" method="post">
                                            {{csrf_field()}}
                                          <table class="table" style="">
                                            <thead>
                                              <tr>

                                                <th>product</th>
                                                <th>quantity</th>
                                                <th style="width: 40px">price</th>
                                              </tr>
                                            </thead>


                                            <tbody class="order-list">

                                            </tbody>
                                          </table>
                                          {{--  <div class="total-price">
                                            <h4>Total Price:0</h4>
                                          </div>  --}}
                                          {{--  <div>
                                          <button id="add-form-button" type="submit"   class="d-block btn btn-primary disabled " >Add Order</button>
                                          </div>  --}}
                                        </form>

                                        </div><!-- /.row -->









                                      </div><!-- /.container-fluid -->
                                    </div>
                                  </div>


















                                   {{--   @endisset  --}}
                                </div>
                            </div>

                            <!-- shipping informations -->
                        </div>
                        <!-- Right Block: cart subtotal & cart total -->
                        <div class="cart-grid-right col-xs-12 col-lg-3">
                            <div class="cart-summary">
                                <div class="cart-detailed-totals">
                                    <div class="cart-summary-products">
                                        <div class="summary-label">

                                            @if(App\Models\Product::where('inCard',1) -> count() > 0)

                                                There are ({{ App\Models\Product::where('inCard',1) -> count() }}) items in your cart
                                            @else
                                                There are no items in your cart
                                            @endif

                                              </div>
                                    </div>

                                    <div class="">
                                        <div class="cart-summary-line cart-total">
                                            <span class="label">Total:</span>

                                            <span class="total-price"><h4>Total Price:0</h4></span>
                                        </div>

                                    </div>

                                </div>


                                <div class="checkout text-xs-center card-block">
                                    <a href="" type="button" class="btn btn-primary"> proceed to payment
                                    </a>
                                </div>


                            </div>



                    </div>

                </section>
            </div>
        </div>
    </div>
@stop


@section('scripts')
    <script>


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

  $(document).on('click', '.remove-from-cart', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'post',
                url: $(this).attr('data-url-product'),
                data: {
                    'product_id': $(this).attr('data-id-product'),
                 },
                success: function (data) {
                    if(data.card ){
                        location.reload();
                        alert('successfully deleted from card list')
                       }
                }
            });
        });

        $(document).on('click', '.add', function (e) {
                e.preventDefault();
                var name=$(this).data('name');
                var id=$(this).data('id');
                var price=$(this).data('price');
                $(this).removeClass('btn-primary').addClass('btn-default disabled');

              var html=`



              <tr>
                <td>${name}</td>
                <td><input type="number" data-price="${price}"  name="quantities[]" class="form-control input-sm product-quantity" min="1" value="1"></td>
                <td><input type="hidden" value="${id}" name="products_ids[]"></td>
                <td class="product-price">${price}</td>
                <td><button class="btn btn-danger  btn-sm trash" data-id="${id}"><span class="fa fa-trash"></span></button></td>
                </tr>
`;

                 $('.order-list').append(html);

            });
            $('body').on('click','.trash',function(e){
                e.preventDefault();
                var id=$(this).data('id');
                 $(this).closest('tr').remove();
                  $('.product-'+id).removeClass('btn-default disabled').addClass('btn-primary');
                  calculete();
            });
            $('body').on('keyup change','.product-quantity',function(){

                var ProductQuantity=parseInt($(this).val());
                var ProductPrice= $(this).data('price');
                var TotalPrice=ProductQuantity*ProductPrice;
                $(this).closest('tr').find('.product-price').html(TotalPrice);
                calculete();



              });
              function calculete(){
                var price=0;
            $('.order-list .product-price').each(function(index){
               price+=parseInt($(this).html());
            });
            var html=`<h4>Total Price:${price}</h4>`
            $('.total-price').html(html);
              if(price>0)  {
                 $('#add-form-button').removeClass('disabled')
              }else{
                $('#add-form-button').addClass('disabled')
              }
            }

    </script>
    @stop
