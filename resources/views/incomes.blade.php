     <table >
         <tr>
             <th>No</th>
             <th>Fecha</th>
             <th>Comprobante</th>
             <th>Num. de Orden</th>
             <th>Proveedor</th>
             <th>Total</th>
             <th>Num. de Factura</th>
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
             <td>{{ \Carbon\Carbon::parse($value['created_at'])->setTimezone('America/La_Paz')->format('d/m/Y') }}</td>
             <td>{{ $value['receipt'] }}</td>
             <td>{{ $value['order_number'] }}</td>
             <td>{{ $value['provider'] }}</td>
             <td>{{ $value['total'] }}</td>
             <td>{{ $value['invoice_number'] }}</td>
             @else
             <td> </td>
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
                 {{$detail['total_price']}}
            </td>
            </tr>
            @endforeach
         @endforeach
     </table>  