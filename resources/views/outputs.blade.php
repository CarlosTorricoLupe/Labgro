     <table >
         <tr>
             <th>No</th>
             <th>Comprobante</th>
             <th>Num. de Orden</th>
             <th>Area</th>
             <th>Total</th>

             <th>Articulo</th>
             <th>Cantidad</th>
             <th>Precio Unit</th>
             <th>Precio Total</th>
         </tr>
         @foreach ($colection as $key => $value)
         @foreach ($value['details'] as $key => $detail)
         <tr>
             @if($key == 0 )
             <td>{{ $value['id'] }}</td>
             <td>{{ $value['receipt'] }}</td>
             <td>{{ $value['order_number'] }}</td>
             <td>{{ $value['name'] }}</td>
             <td>{{ $value['total'] }}</td>
             @else
             <td> </td>
             <td> </td>
             <td> </td>
             <td> </td>
             <td> </td>
             @endif
             <td>
                 {{$detail['name_article']}}
            </td>
            <td>
                 {{$detail['quantity']}}
            </td>
            <td>
                 {{$detail['unit_price']}}
            </td>
            <td>
                 {{$detail['total']}}
            </td>
            </tr>
            @endforeach
         @endforeach
     </table>
