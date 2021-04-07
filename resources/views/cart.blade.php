@isset($cartData)
    <table class="cart-table">
      @foreach ($cartData as $cartItem)
        <tr>
          <td><img src="{{url($cartItem->image_path)}}" class="product-image-cart"></td>
          <td>{{ $cartItem->name }}</td>
          <td>{{ $cartItem->price }}</td>
        </tr>
      @endforeach
    </table>
    @isset($totalPrice)
      <p class="total-price"> Total : {{ $totalPrice }} </p>
    @endisset
    <a class="waves-effect waves-light btn-small buy-button">Buy</a>
    <a class="waves-effect waves-light btn-small add-to-cart-button" onclick="clearCart()">Clear all</a>
@endisset
@isset($emptyCart)
    <p class="empty-cart">{{ $emptyCart }}</p>
@endisset



<script>
  function clearCart() {
    $.ajax({
        method:"GET",
        data: {
            "_token": "{{ csrf_token() }}"
        },
        url:'/clearCartProducts',
        success:function(response){
            var element = document.getElementById("cart-item-badge");
            element.classList.remove("cart-item-badge");
            element.classList.remove("badge");
            element.classList.remove("new");
            element.style.display = 'none';
            $.ajax({
                method:"GET",
                url:'/getCartProducts',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success:function(response){
                    $('#dropdown1').html(response);
                }
            });
        }
    });
  }
</script>