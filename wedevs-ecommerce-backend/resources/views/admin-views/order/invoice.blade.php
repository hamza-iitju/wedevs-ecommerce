<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">
    <style media="all">
        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: sans-serif;
            color: #333542;
        }

        /* IE 6 */
        * html .footer {
            position: absolute;
            top: expression((0-(footer.offsetHeight)+(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)+(ignoreMe=document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))+'px');
        }

        body {
            font-size: .875rem;
        }

        .gry-color *,
        .gry-color {
            color: #333542;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .5rem .7rem;
        }

        table.padding td {
            padding: .7rem;
        }

        table.sm-padding td {
            padding: .2rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #424446;
        }

        .col-12 {
            width: 100%;
        }

        [class*='col-'] {
            float: left;
            /*border: 1px solid #F3F3F3;*/
        }

        .row:after {
            content: ' ';
            clear: both;
            display: block;
        }

        .wrapper {
            width: 100%;
            height: auto;
            margin: 0 auto;
        }

        .header-height {
            height: 15px;
            border: 1px red;
            background: red;
        }

        .content-height {
            display: flex;
        }

        .customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .header {
            border: 1px solid #ecebeb;
        }

        .customers th {
            /*border: 1px solid #A1CEFF;*/
            padding: 8px;
        }

        .customers td {
            /*border: 1px solid #F3F3F3;*/
            padding: 14px;
        }

        .customers th {
            color: white;
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: red;

        }

        .big-footer-height {
            height: 250px;
            display: block;
        }

        .table-total {
            font-family: Arial, Helvetica, sans-serif;
        }

        .table-total th,
        td {
            text-align: left;
            padding: 10px;
        }

        .footer-height {
            height: 75px;
        }

        .for-th {
            color: white;
            border: 1px solid red;
        }

        .for-tb {
            border: 1px solid #D8D8D8;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: .85rem;
        }

        .currency {}

        .strong {
            font-size: 0.95rem;
        }

        .bold {
            font-weight: bold;
        }

        .for-footer {
            position: relative;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: rgb(214, 214, 214);
            height: auto;
            margin: auto;
            text-align: center;
        }

    </style>
</head>

<body>
    @php
        $company_phone = '+8801744952899';
        $company_email = 'hamza.iitju@gmail.com';
        $company_name = 'Wedevs';
        $company_web_logo = 'logo.png';
        $company_mobile_logo = 'logo.png';
    @endphp


    <div style="background: red;padding: 0.5rem; color:none">
        sjfkldfj

    </div>
    <div class="first" style="display: block; height:auto !important;">
        <table>
            <tr>
                <div class="row">
                    <div class="col-12 " style="padding:15px;" header>
                        <div style="float: left;padding: 15px">
                            <img height="70" width="200" src="{{ asset("storage/company/$company_web_logo") }}" alt="">
                            <p style="margin-bottom: 0px;">Ph:{{ $company_phone }}</p>
                            <p style="margin-top: 5px; margin-bottom: 0px;">Email:{{ $company_email }}</p>
                        </div>
                        <div style="float: right;padding: 0 15px 15px 15px">
                            <h1 style="color: #030303; margin-bottom: 0px; margin-left:40%;">INVOICE</h1>
                            <h3 style="color: #030303; margin-top: 4px; margin-bottom:2px; margin-left:40%;">Invoice id
                            </h3>
                            <div style=" font-size:20px;">
                                <strong
                                    style="color:red; margin-top:4px;  margin-left:40%;">{{ $order->id }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
        </table>
    </div>
    <hr>
    <table>
        <div class="row" style="margin-left: 2%; margin-right:2%;">
            <section>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 41%">
                            <div style="float: left">
                                <h4 style="margin: 0px;">Invoice To,</h4>
                                <p style=" margin-top: 6px; margin-bottom:0px;">{{ $order->shipping['person_name'] }}
                                </p>
                                <p style=" margin-top: 6px; margin-bottom:0px;">{{ $order->shipping['email'] }}</p>
                                <p style=" margin-top: 6px; margin-bottom:0px;">{{ $order->shipping['phone'] }}</p>
                                <p style=" margin-top: 6px; margin-bottom:0px;">
                                    {{ $order->shipping ? $order->shipping['address'] : '' }}</p>
                                <p style=" margin-top: 6px; margin-bottom:0px;">
                                    {{ $order->shipping ? $order->shipping['city'] : '' }}</p>
                            </div>
                        </td>
   
                        <td>
                            <div style="float:right ">
                                <h4 style="color: #130505 !important; margin:0px;">Payments Details</h4>
                                <h5 style="color: #414141 !important ; margin-top:4px; margin-bottom:0px;">
                                    {{ $order->payment_method }}</h5>
                                <p>{{ $order->payment_status }}, {{ date('y-m-d', strtotime($order['created_at'])) }}
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </section>
        </div>
    </table>

    <br>

    <div class="row" style="margin: 20px; display:block; height:auto !important ;">
        <div class="col-12 content-height" style="">
            <table class="customers">
                <tr class="for-th">
                    <th class="for-th">No.</th>
                    <th class="for-th">Item Description</th>
                    <th class="for-th">Unit Price</th>
                    <th class="for-th">Qty</th>

                    <th class="for-th">Total</th>
                </tr>
                @php
                    $subtotal = 0;
                    $total = 0;
                    $sub_total = 0;
                    $total_tax = 0;
                    $total_shipping_cost = 100;
                    $total_discount_on_product = 0;
                @endphp
                @foreach ($order->details as $key => $details)
                    @php $subtotal=($details['price'])*$details->qty @endphp
                    <tr class="for-tb" style=" border: 1px solid #D8D8D8;">
                        <td class="for-tb">{{ $key + 1 }}</td>
                        <td class="for-tb">{{ $details['product'] ? $details['product']->name : '' }}</td>
                        <td class="for-tb">৳ {{ $details['price'] }}</td>
                        <td class="for-tb">{{ $details->qty }}</td>
                        <td class="for-tb">৳ {{ $subtotal }}</td>
                    </tr>

                    @php
                        $sub_total += $details['price'] * $details['qty'];
                        $total += $subtotal;
                    @endphp
                @endforeach

            </table>
        </div>
    </div>

    <div style="padding:0 1.5rem; display:block; height:auto !important;">
        <table style="width: 46%;margin-left:auto;  " class="text-right sm-padding  strong">
            <tbody>

                <tr>
                    <th class="gry-color text-left strong bold">Sub Total</th>
                    <td>{{ $sub_total }}</td>

                </tr>
                <tr>
                    <th class="gry-color text-left strong bold">Shipping</th>
                    <td>৳ 100</td>
                </tr>
                <tr>
                    <th class="gry-color text-left strong bold">Coupon Discount</th>
                    <td>- 0</td>
                </tr>
                <tr class="border-bottom">
                    <th class="gry-color text-left strong bold">Discount on Product</th>
                    <td>- 0</td>
                </tr>
                <tr>
                    <th class="gry-color text-left strong bold">Total</th>
                    <td class="bold">{{ $order->order_amount }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <br>
    <br><br>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="row" style="display:block;">
        <hr>
        <div class="col-12">
            <section>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 33%">
                            <div>
                                <p style="font-size: 12px"> Phone : +8801744952899</p>
                            </div>
                        </td>
                        <td style="width: 33%">
                            <div>
                                <p style="font-size: 12px">
                                    Website : {{ url('/') }}
                                </p>
                            </div>
                        </td>
                        <td style="width: 33%">
                            <div style="right: 0">
                                <p style="font-size: 12px;text-align: right;">
                                    Email : hamza.iitju@gmail.com
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </section>
        </div>
    </div>
</body>

</html>
