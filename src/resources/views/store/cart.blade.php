  @extends('store.layouts.melamart')

  @section('title')
  <title>Cart | MelaMart</title>
  @endsection
  @section('scripts')
  <script>
      var id = <?php echo json_encode($productId); ?>;
  </script>
  @endsection

  @section('cartpage')
  <!-- cart-area start -->
  <div class="cart-area ptb-100">
      <div class="container">
          <!-- get total items in cart -->
          @php
          $total_cart_items = count($allCartItems);
          @endphp
          <div class="row">
              <!-- cart count start -->
              <div class="col-12">
                  <h6 class="count-text">
                      Shopping Cart ({{$total_cart_items}} items)
                  </h6>
              </div>
              <!-- cart count end -->
              @if( count($allCartItems) != 0)
              <div class=" col-lg-10 offset-lg-1 col-12">
                  <!-- table title start -->
                  <div class="row ">
                      <div class="col-lg-6 col-sm-6 d-none d-sm-block d-md-block d-lg-block">
                          <h6>Item Details</h6>
                      </div>
                      <div class="col-lg-3 col-sm-3 d-none d-sm-block d-md-block d-lg-block text-center">
                          <h6>Quantity</h6>
                      </div>
                      <div class="col-lg-2 col-sm-2 d-none d-sm-block d-md-block d-lg-block text-center">
                          <h6>Price</h6>
                      </div>
                  </div>
                  <!-- table title end -->
                  <!-- table contents start -->
                  <div class="row cart-wrap">
                      <!-- items in stock start -->
                      @foreach($arrayProductsInStock as $product)
                      @php
                      $cart_product_key = $loop->iteration;
                      @endphp
                      <!-- cart info start -->
                      <div class="col-12">
                          <div class="container">
                              <div class="row row-style b-shadow">
                                  <!-- item details start -->
                                  <div class="col-lg-6 col-sm-6 col-12">
                                      <div class="row">
                                          <!-- item image -->
                                          <div class="col-lg-3 col-3 col-sm-3 my-auto text-center">
                                              @foreach ($product->images as $key => $image)
                                              <a href="/item/{{ $product->slug}}">
                                                  @if ($key == 0)
                                                  <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="" class="img-fluid" class="img-width">
                                                  @endif
                                              </a>
                                              @endforeach
                                          </div>
                                          <!-- item title -->
                                          <div class="col-lg-9 col-9 col-sm-9 my-auto">
                                              <p class="product"><a href="/item/{{$product->slug}}">{{$product->title}}</a></p>
                                              @if($product->quantity > 0)
                                              <p class="ptice"><span class="d-inline-block d-sm-none">
                                                      @foreach($allCartItems as $cart_item)
                                                      @if($product->id == $cart_item->product_id)
                                                      <span class="total-cart" id="item_total{{$product->id}}"> <span> &#8358;</span><?php echo (number_format($product->total_price * $cart_item->quantity)); ?></span>
                                                      <span class="initial-cart" id="item_initial{{$product->id}}"> <span> &#8358;</span><?php echo (number_format($product->initial_price * $cart_item->quantity)); ?></span><br>
                                                      @endif
                                                      @endforeach
                                              </p>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                                  <!-- item details end -->
                                  <!-- adds white space -->
                                  <div class="col-12 d-inline-block d-sm-none">
                                      <hr class="divider visibility-none">
                                  </div>
                                  <!-- item quantity adjust start -->
                                  <div class="col-lg-3 col-8 col-sm-3  my-auto text-center">
                                      @if($product->quantity > 0)
                                      <div class="quantity cart-plus-minus23 cart-plus-minus123{{ $product->id }}">
                                          @foreach($allCartItems as $cart_item)
                                          @if($product->id == $cart_item->product_id)
                                          <div class="input-group input-group-sm mb-3 text-center my-auto">
                                              <div class="input-group-prepend">
                                                  <button class="btn btn-outline-secondary qtybutton_cart{{ $cart_item->product_id }}" href="javascript:void(0);" stype="button">-</button>
                                              </div>
                                              <input type="text" readonly id="quantity{{ $cart_item->product_id }}" class="form-control" value="{{$cart_item->quantity}}">
                                              <div class="input-group-append">
                                                  <button class="btn btn-outline-secondary qtybutton_cart{{ $cart_item->product_id }}" href="javascript:void(0);" stype="button">+</button>
                                              </div>
                                          </div>
                                          <!-- update quantity form start -->
                                          <form class="d-none" id="update_quantity{{ $cart_item->product_id }}" action="/cart/update/{{ $cart_item->product_id }}/{{ $cart_item->quantity }}" method="POST">
                                              @csrf
                                              @method('PUT')
                                              <p>form{{ $cart_item->quantity }}</p>
                                              <p>{{ $product->id }}</p>
                                          </form>
                                          <!-- update quantity form end -->
                                          @php
                                          $total = $cart_item->quantity * $product->total_price;
                                          @endphp
                                          @endif
                                          @endforeach
                                      </div>
                                      @endif
                                  </div>
                                  <!-- item quantity adjust end -->
                                  <!-- item price start -->
                                  <div class="col-lg-2 col-12 col-sm-2 my-auto text-center  d-none d-sm-block">
                                      @if($product->quantity > 0)
                                      <p class="ptice"><span>
                                              @foreach($allCartItems as $cart_item)
                                              @if($product->id == $cart_item->product_id)
                                              <span class="total" id="item_total_bg{{$product->id}}"> <span> &#8358;</span><?php echo (number_format($product->total_price * $cart_item->quantity)); ?></span><br>
                                              <span class="initial" id="item_initial_bg{{$product->id}}"> <span> &#8358;</span><?php echo (number_format($product->initial_price * $cart_item->quantity)); ?></span><br>
                                              @endif
                                              @endforeach
                                      </p>
                                      @endif
                                  </div>
                                  <!-- item price end-->
                                  <!-- delete from cart start -->
                                  <div class="col-lg-1 col-4 col-sm-1  my-auto text-center">
                                      <p class="del-btn"><a href="" onclick="event.preventDefault();
                                          document.getElementById('delCart{{$product->id}}').submit();">
                                              <span class="iconify" data-icon="iwwa:trash" data-inline="false"></span>
                                          </a></p>

                                      <form id="delCart{{$product->id}}" action="/cart/delete/{{$product->id}}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <input type="number" name="product_id" hidden value="{{$product->id}}">
                                      </form>
                                  </div>
                                  <!-- delete from cart end -->
                              </div>
                          </div>
                      </div>
                      <!-- cart info end -->
                      <!-- adds white space -->
                      <div class="col-lg-12">
                          <hr class="divider visibility-none">
                      </div>
                      <!-- get total cost of cart items -->
                      @foreach ($allCartItems as $cart_item)
                      @if($product->id == $cart_item->product_id)
                      @php
                      $total = $cart_item->quantity * $product->total_price;
                      $sum = $total;
                      $cart_total_array[] = $sum;
                      $cart_total = array_sum($cart_total_array);
                      @endphp
                      @endif
                      @endforeach
                      @endforeach
                      <!-- items in stock end -->
                      <!-- for out of stock items start -->
                      @if (count($arrayProductsNoStock) != 0)
                      @foreach($arrayProductsNoStock as $product)
                      @php
                      $cart_no_stock_product_key = $loop->iteration;
                      @endphp
                      <div class="col-12">
                          <div class="container">
                              <div class="row row-style no-stock b-shadow">
                                  <!-- item details -->
                                  <div class="col-lg-6 col-sm-6 col-12">
                                      <div class="row">
                                          <!-- item image -->
                                          <div class="col-lg-3 col-3 col-sm-3 my-auto text-center">
                                              @foreach ($product->images as $key => $image)
                                              <a href="/item/{{ $product->slug}}">
                                                  @if ($key == 0)
                                                  <img src="{{env('IMAGE_URL')}}{{$image->image_link}}" alt="" class="img-fluid img-width">
                                                  @endif
                                              </a>
                                              @endforeach
                                          </div>
                                          <!-- item title -->
                                          <div class="col-lg-9 col-9 col-sm-9 my-auto">
                                              <p class="product"><a href="/item/{{$product->slug}}">{{$product->title}}</a></p>
                                              <p class="red">Out of Stock</p>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- adds white space -->
                                  <div class="col-12 d-inline-block d-sm-none">
                                      <hr class="divider visibility-none">
                                  </div>
                                  <!-- item quantity adjust start -->
                                  <div class="col-lg-3 col-8 col-sm-3  my-auto text-center">
                                  </div>
                                  <!-- item quantity adjust end -->
                                  <!-- item price start -->
                                  <div class="col-lg-2 col-12 col-sm-2 my-auto text-center  d-none d-sm-block">
                                  </div>
                                  <!-- item price end -->
                                  <!-- delete from cart start -->
                                  <div class="col-lg-1 col-4 col-sm-1  my-auto text-center">
                                      <p class="del-btn"><a href="" onclick="event.preventDefault();
                                     document.getElementById('delCart{{$product->id}}').submit();">
                                              <span class="iconify" data-icon="iwwa:trash" data-inline="false"></span>
                                          </a></p>

                                      <form id="delCart{{$product->id}}" action="/cart/delete/{{$product->id}}" method="POST">
                                          @csrf
                                          @method('DELETE')
                                          <input type="number" name="product_id" hidden value="{{$product->id}}">
                                      </form>
                                  </div>
                                  <!-- delete from cart end -->
                              </div>
                          </div>
                      </div>
                      <!-- adds white space -->
                      <div class="col-lg-12">
                          <hr class="divider visibility-none">
                      </div>
                      @endforeach
                      @endif
                  </div>
              </div>
              @else
              <!-- if cart is empty start -->
              <div class="col-12 text-center empty" >
                  <!-- displays after making a purchase -->
                  @if (session()->has('success-payment'))
                  <span ><i class="fa fa-smile-o" aria-hidden="true"></i></span>
                  <h6>Thank you for your Purchase.</h6>
                  <p>A confirmation email was sent.</p>
                  <!-- displays if cart is empty -->
                  @else
                  <span ><i class="fa fa-frown-o" aria-hidden="true"></i></span>
                  <h6>Oops! no items in your cart yet.</h6>
                  @endif
              </div>
              <div class="col-12">
                  <hr>
              </div>
              <!-- if cart is empty end -->
              @endif
              <!-- cart action start -->
              <div class="col-12">
                  <form action="cart">
                      <div class="row mt-60">
                          <div class="col-lg-10 offset-lg-1">
                              <div class="row">
                                  <div class="col-sm-4 col-12">
                                      <div class="cartcupon-wrap">
                                          <ul class="d-flex">
                                              <li><a href="shop.html">Continue Shopping</a></li>
                                          </ul>
                                          <h3>Cupon</h3>
                                          <p>Enter Your Cupon Code if You Have One</p>
                                          <div class="cupon-wrap">
                                              <input type="text" placeholder="Cupon Code">
                                              <button>Apply</button>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-lg-4 offset-lg-4 col-sm-5 offset-sm-3 col-12">
                                      <div class="cart-total text-right">
                                          <h3>Cart Totals</h3>
                                          <ul>
                                              <li id="cart_total_sub"><span class="pull-left">Subtotal </span>
                                                  <span>
                                                      @if (isset($cart_total))
                                                      &#8358;<?php echo (number_format($cart_total)); ?>
                                                      @else
                                                      0
                                                      @endif
                                                  </span>
                                              </li>
                                              <li id="cart_total"><span class="pull-left"> Total </span>
                                                  <span>
                                                      @if (isset($cart_total))
                                                      &#8358;<?php echo (number_format($cart_total)); ?>
                                                      @else
                                                      0
                                                      @endif
                                                  </span>
                                              </li>
                                          </ul>
                                          @if( count($arrayProductsInStock) != 0)
                                          <a href="" onclick="event.preventDefault();
                                                document.getElementById('submit').click();">Proceed to Checkout
                                          </a>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                          </div>

                      </div>
                  </form>
              </div>
              <!-- cart action end -->
          </div>
      </div>
  </div>
  <!-- cart-area end -->
  <!-- form to create customer invoice -->
  <form id="invoice_details" method="POST" action="/invoice">
      @csrf
      @guest
      @else
      <input type="hidden" name="email" value="{{ Auth::user()->email }}">
      <input type="hidden" name="first_name" value="{{ Auth::user()->firstname }}">
      <input type="hidden" name="last_name" value="{{ Auth::user()->lastname }}">
      <input type="hidden" name="email" value="{{ Auth::user()->email }}">
      <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
      @endguest
      <?php $stringProductId = implode(',', $productId); ?>
      @if( count($arrayProductsInStock) != 0)
      <input type="hidden" name="product_id" value="{{$stringProductId}}">
      @endif
      <button id="submit" hidden type="submit"></button>
      @isset($msg)
      {{ $msg }}<br>
      @endisset
  </form>
  @endsection
  @section('cart-quantity-js')
  <script src="{{ mix('/js/cart.js') }}"></script>
  @endsection