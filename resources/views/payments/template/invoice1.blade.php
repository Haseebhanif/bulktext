<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Invoice</title>

    <style>
        .invoice-box {
            max-width: 800px;
            height: 900PX;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<?php

$fmt = new NumberFormatter( 'en_GB', NumberFormatter::CURRENCY );
$getInPounds = $paymentRecord->amount/100;
$vat = $paymentRecord->vat;

$exVat = number_format($getInPounds-$paymentRecord->vat,2);
?>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            @if($paymentRecord->company->tenantParent->logo)
                                <img src="{{$paymentRecord->company->tenantParent->logo}}" style="width: 50%; max-width: 200px" />
                            @else
                                <h1 style="font-size: medium;"> {{$paymentRecord->company->tenantParent->tenant_name ?? 'INVOICE'}}</h1>
                            @endif
                        </td>

                        <td>
                            Invoice #: {{$paymentRecord->created_at->format('dmY')}}-{{$paymentRecord->id}}-{{$paymentRecord->created_at->format('His')}}<br />
                            Created: {{$paymentRecord->created_at->format('F d, Y')}}<br />
                            Due: {{$paymentRecord->created_at->format('F d, Y')}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                       To:      {{$paymentRecord->company->tenantParent->company_name}}<br/>
                                {{$paymentRecord->company->tenantParent->address1}}<br/>
                                {{$paymentRecord->company->tenantParent->company_email}}<br/>
                                {{$paymentRecord->company->tenantParent->company_phone}}<br/>
                        </td>

                        <td>
                         From:
                            @if($paymentRecord->company->company_name)
                                {{$paymentRecord->company->company_name}}<br/>
                            @endif
                            @if($paymentRecord->company->address1)
                                {{$paymentRecord->company->address1}}<br/>
                            @endif
                            @if($paymentRecord->company->post_code)
                                {{$paymentRecord->company->post_code}}<br/>
                            @endif
                            @if($paymentRecord->company->company_phone)
                                {{$paymentRecord->company->company_phone}}<br/>
                            @endif
                            @if($paymentRecord->company->email)
                             {{$paymentRecord->company->email}}<br/>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>Payment Method</td>

            <td>REF #</td>
        </tr>

        <tr class="details">
            <td>Card</td>

            <td>{{str_replace('pi_','DB_',$paymentRecord->payment_ref)}}</td>
        </tr>

        <tr class="heading">
            <td>Item</td>
            <td>Price</td>
        </tr>

        <tr class="item">
            <td>SMS Credits: {{$paymentRecord->credits}}</td>

            <td style="text-transform: uppercase;"> ex VAT: {{$paymentRecord->currency}} {{$exVat}}</td>
        </tr>

        <tr class="total">
            <td></td>
            <td style="text-transform: uppercase;">VAT {{$paymentRecord->vat_rate}}%: {{$paymentRecord->currency}} {{$fmt->formatCurrency((float)$vat,'GBP')}}</td>
        </tr>
        <tr class="total">
            <td></td>
            <td style="text-transform: uppercase;">Total Inc VAT: {{$paymentRecord->currency}} {{$fmt->formatCurrency((float)$getInPounds,'GBP')}}</td>
        </tr>
    </table>
</div>
<p style="text-align: center; width: 100%">


<span style="margin-right: 10px">
    {{$paymentRecord->company->tenantParent->company_name  ?? ''}}
</span>
<span style="margin-right: 10px"> {{$paymentRecord->company->tenantParent->company_no ?? '' }} </span><span style="margin-right: 10px">{{$paymentRecord->company->tenantParent->company_vat ? 'VAT No:' :''}} {{$paymentRecord->company->tenantParent->company_vat ?? ''}}</span>
</p>
</body>
</html>
