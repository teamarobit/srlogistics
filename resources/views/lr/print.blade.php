
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<title>invoice</title>
<link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,500,600,700&amp;display=swap" rel="stylesheet">
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">-->
<style type="text/css">
 @page  { size:8.5in 11in; margin: 0.3cm }
        @media  print{
                html, body {
              height:auto; 
              margin: 0 !important; 
              padding: 0 !important;
              overflow: hidden;
            }

        }
    .printbtn{
        margin-left: 90%;
        background-color: #032671;
        text-decoration: none;
        color: #fff;
        outline: none;
        background-color: #032671;
        box-shadow: none !important;
        padding: 10px;
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        line-height: 16px;
        padding: 15px 30px;
        cursor: pointer;
        white-space: nowrap;
        border: 0 !important;
        border-radius: 4px;
    }
    body
    {
        font-family: "IBM Plex Sans", sans-serif;
        font-size: 0.875rem;
        font-weight: 400;
        line-height: 1.5;
        color: #001737;
        background: #f8f8f8;
    }
    a {
        color: #032671;
        text-decoration: none;
        background-color: transparent;
    }

    .pcs-template {
        font-size: 9pt;
        color: #333333;
        background: #ffffff;
        max-width: 8.27in;
        margin-left: auto;
        margin-right: auto;
    }

    .pcs-header-content {
        font-size: 9pt;
        color: #333333;
        background-color: #ffffff;
    }

    .pcs-template-body {
        /*padding: 0.45in 0.400000in 0 0.550000in;*/
    }
    .pcs-template-body {
        padding: 10px;
    }

    .pcs-template-footer {
        font-size: 8pt;
        color: #adadad;
        background-color: #ffffff;
    }

    .pcs-footer-content {
        word-wrap: break-word;
        color: #adadad;
        border-top: 1px solid #e3e3e3;
    }

    .pcs-label {
        color: #817d7d;
        font-size: 8pt;
    }

    .pcs-entity-title {
        font-size: 12pt;
        color: #032671;
    }

    .pcs-orgname {
        font-size: 10pt;
        color: #333;
        line-height: 1.0;
    }

    .pcs-customer-name {
        font-size: 8pt;
        color: #333333;
    }

    .pcs-itemtable-header {
        background-color: #edf3ff;
        font-weight: 600;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }

    .pcs-itemtable-breakword {
        word-wrap: break-word;
        padding: 5px!important;
        font-size: 7pt;
        line-height: 1.2;
    }

    .pcs-taxtable-header {
        font-size: 9pt;
        color: #ffffff;
        background-color: #2F81B7;
    }

    .breakrow-inside {
        page-break-inside: avoid;
    }

    .breakrow-after {
        page-break-after: auto;
    }

    .pcs-item-row {
        font-size: 8pt;
        border-bottom: 1px solid #e3e3e3;
        background-color: #ffffff;
        color: #000000;
    }

    .pcs-item-sku {
        margin-top: 2px;
        font-size: 10px;
        color: #444444;
    }

    .pcs-item-desc {
        color: #727272;
        font-size: 8pt;
    }

    .pcs-balance {
        background-color: #e7f3f2;
        font-size: 10pt;
        color: #000000;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }

    .pcs-totals {
        font-size: 9pt;
        color: #000000;
        background-color: #ffffff;
    }

    .pcs-notes {
        font-size: 8pt;
    }

    .pcs-terms {
        font-size: 8pt;
    }

    .pcs-header-first {
        background-color: #ffffff;
        font-size: 9pt;
        color: #333333;
        height: 0.700000in;
    }

    .pcs-status {
        color: ;
        font-size: 15pt;
        border: 3px solid;
        padding: 3px 8px;
    }

    .billto-section {
        padding-top: 0mm;
        padding-left: 0mm;
    }

    .shipto-section {
        padding-top: 0mm;
        padding-left: 0mm;
    }

    @page  :first {
        @top-center {
            content: element(header);
        }
        margin-top: 0.700000in;
    }

    .pcs-template-header {
        padding: 0 0.400000in 0 0.550000in;
        height: 0.700000in;
    }

    .pcs-template-fill-emptydiv {
        display: table-cell;
        content: " ";
        width: 100%;
    }

    /* Additional styles for RTL compat */

    /* Helper Classes */

    .inline {
        display: inline-block;
    }

    .v-top {
        vertical-align: top;
    }

    .text-align-right {
        text-align: right;
    }

    .rtl .text-align-right {
        text-align: left;
    }

    .text-align-left {
        text-align: left;
    }

    .rtl .text-align-left {
        text-align: right;
    }

    /* Helper Classes End */

    .item-details-inline {
        display: inline-block;
        margin: 0 10px;
        vertical-align: top;
        max-width: 70%;
    }

    .total-in-words-container {
        width: 100%;
        margin-top: 10px;
    }

    .total-in-words-label {
        vertical-align: top;
        padding: 0 10px;
    }

    .total-in-words-value {
        width: 170px;
    }

    .total-section-label {
        padding: 5px 10px 5px 0;
        vertical-align: middle;
    }

    .total-section-value {
        width: 120px;
        vertical-align: middle;
        padding: 10px 10px 10px 5px;
    }

    .rtl .total-section-value {
        padding: 10px 5px 10px 10px;
    }

    .tax-summary-description {
        color: #727272;
        font-size: 8pt;
    }

    .bharatqr-bg {
        background-color: #f4f3f8;
    }

    /* Overrides/Patches for RTL compat */

    .rtl th {
        text-align: inherit;
        /* Specifically setting th as inherit for supporting RTL */
    }

    /* Overrides/Patches End */

    /* Subject field styles */

    .subject-block {
        margin-top: 20px;
    }

    .subject-block-value {
        word-wrap: break-word;
        white-space: pre-wrap;
        line-height: 14pt;
        margin-top: 5px;
    }

    /* Subject field styles End*/

    .lineitem-column {
        padding: 10px 10px 5px 10px;
        word-wrap: break-word;
    }
    .print
    {
        position: fixed;
        right: 15px;
        top: 15px;
    }
    .pcs-template-body{
        page-break-after: always;
    }
    @media  print{
        .print, .hide{
            display: none;
        }
    }
    body.A5 .sheet {
        margin: 0 auto;
        height: auto!important;
    }
    .pcs-item-row:nth-child(2) {
    padding-left: 5px!important;
    }
    .pcs-item-row:last-child {
        padding-right: 0px!important;
    }
    .sheet.padding-10mm {
    padding: 5mm;
    }
    .pcs-itemtable {
        border-top: 1px solid #ccc;
        border-right: 1px solid #ccc;
    }
    .pcs-itemtable td {
        border: 1px solid #ccc;
        padding-left: 2px!important;
        padding-right: 2px!important;
        border-top: 0;
        border-right: 0;
        text-align: center!important;
    }
    .pcs-totals {
        border-right: 1px solid #ccc;
        margin-top: 10px;
        border-top: 1px solid #ccc;
    }
    .pcs-totals td {
        border: 1px solid #ccc;
        border-right: 0;
        border-top:0;
    }
    .pcs-table {
    border-top: 1px solid #ccc;
    border-right: 1px solid #ccc;
    margin-bottom: 10px;
    }
    .pcs-table td {
        border: 1px solid #ccc;
        border-right: 0;
        border-top: 0;
    }
</style>

</head>

<body class="A5" style="padding: 10px 0px;">
    
<div id="ember2473" class="ember-view">

<input class="print printbtn" type="button" value="Print" onclick="window.print()"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="{{ $trip ? route('trip.details', $trip) : route('trip.index') }}" class="hide">Back</a>
<section class="sheet padding-10mm">
    <div class="pcs-template">
        
        <div class="pcs-template-body" id="printble_table">
            <table style="width:100%;table-layout: fixed;">
                <tbody>
                    <tr>
                        <td style="vertical-align: top; width:50%;">
                            
                            <span class="pcs-orgname"><b>SR Logistics</b></span><br>
                            <span class="pcs-label">
                                #16, Ashok Puram School Road Yeshwanthpur  560022
                                <br>
                                 GSTIN : 29AAICC3011E1Z3 
                                 <br>
                                 PAN Number : ALHP
                                 <br>
                                 <span style="color: #000; font-size: 14px;">At Carriers Risk/Owners Risk</span>
                            
                            </span>
                        </td>
                        <td style="vertical-align: top; text-align:right;width:50%;">
                            <img src="{{ asset('images/qr-code.png') }}" alt="QR Code" width="30%">
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="clear:both;width:100%;margin-top:-7px;table-layout:fixed;">
                <tbody>
                    <tr>
                        <td style="width:40%;vertical-align:top;word-wrap: break-word;">
                            <div style="width: 300px; display: inline-block;">
                                  <p style="margin-bottom: 5px; margin-top: 0; color: #000; font-size: 14px;">Consigner Name & Address </p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">Britania Kolkata</p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">13946 Desiree Burgs Suite 113</p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">Port Clintonborough</p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">Georgia 974-395</p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">Phone: (006)-336-077</p>
                            </div>
                            <div style="width: 300px; display: inline-block; vertical-align: top;">
                                  <p style="margin-bottom: 5px; margin-top: 0; color: #000; font-size: 14px;">Consignee Name & Address </p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">Samsung Hydrabad</p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">13946 Desiree Burgs Suite 113</p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">Port Clintonborough</p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">Georgia 974-395</p>
                                  <p style="margin-bottom: 3px; margin-top: 0; font-size: 13px; color: #555;">Phone: (006)-336-077</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="pcs-table" border="0" cellspacing="0" cellpadding="0" style="width:100%;margin-top:10px;border-collapse;table-layout: fixed;word-wrap: break-word;">
                <tbody>
                    <tr>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">LR #</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">LR Party #</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">LR Date</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">Source</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px; width: 70px;">Destination</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px; width: 100px;">Truck Number</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">Truck Size</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">Gross Weight</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">Seal Number</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">Transport Mode</td>
                        <td class="pcs-itemtable-header" style="padding:2px 5px;">Tarpaulin</td>
                    </tr>
                    <tr>
                        <td style="padding: 2px 5px;" id="tmp_entity_date">#LR123</td>
                        <td style="padding:2px 5px;" id="tmp_due_date">#LR4456</td>
                        <td style="padding: 2px 5px;" id="tmp_entity_date">12/11/2025</td>
                        <td style="padding: 2px 5px;" id="tmp_entity_date">Kolkata</td>
                        <td style="padding:2px 5px;" id="tmp_due_date">Durgapur</td>
                        <td style="padding: 2px 5px;" id="tmp_entity_date">WB-12-FV44567</td>
                        <td style="padding:2px 5px;" id="tmp_due_date">Large</td>
                        <td style="padding: 2px 5px;" id="tmp_entity_date">123KG</td>
                        <td style="padding:2px 5px;" id="tmp_due_date">1234</td>
                        <td style="padding: 2px 5px;" id="tmp_entity_date">Road</td>
                        <td style="padding:2px 5px;" id="tmp_due_date">No</td>
                    </tr>
                </tbody>
            </table>


            <table style="width:100%;margin-top:0px;table-layout:fixed;" class="pcs-itemtable" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr style="height:32px;">
                        <td style="padding: 5px 0px 5px 5px;width: 5%;text-align: center;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            SN
                        </td>
                        <td style="padding: 5px 10px 5px 20px; text-align: left;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            Invoice #
                        </td>
                        <td style="padding: 5px 10px 5px 5px;text-align: right;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">Invoice Date</td>
                        <td style="padding: 5px 10px 5px 5px;text-align: right; width: 120px;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            Description
                        </td>
                        <td style="padding: 5px 10px 5px 5px;text-align: right;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            No. of Packages
                        </td>
                        <td style="padding: 5px 10px 5px 5px;text-align: right;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            Total Amount
                        </td>
                        <td style="padding: 5px 10px 5px 5px;text-align: right; width: 100px;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            EWAY Bill No.
                        </td>
                        
                        <td style="padding: 5px 10px 5px 5px;text-align: right;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            EWAY Bill Date
                        </td>
                        <td style="padding: 5px 10px 5px 5px;text-align: right;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            Valid Till
                        </td>
                        <td style="padding: 5px 10px 5px 5px;width: 100px;text-align: right;" id="" class="pcs-itemtable-header pcs-itemtable-breakword">
                            Freight Amount
                        </td>

                    </tr>
                </thead>
                    <tbody class="itemBody">
                    <tr class="breakrow-inside breakrow-after">
                        <td rowspan="1" valign="top" style="padding: 10px 0 10px 5px;text-align: center;word-wrap: break-word;" class="pcs-item-row">
                            
                                                        1
                            
                        </td>

                        <td rowspan="1" valign="top" style="padding: 10px 0px 10px 20px;" class="pcs-item-row">
                            <div>
                                <div>
                                    <span style="word-wrap: break-word;" id="tmp_item_name">#INV001</span>
                                </div>
                            </div>
                        </td>
                        <td rowspan="1" valign="top" style="padding: 10px 0px 10px 20px; text-align:right;" class="pcs-item-row">15/12/2024</td>
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            Lorem ipsum doller sit amet.
                        </td>
                        <td rowspan="1" valign="top" style="padding: 10px 0px 10px 20px; text-align:right;" class="pcs-item-row">12</td>
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            10000.00
                        </td>
                        
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            #BILL6678904
                        </td>
                        
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            12/11/2025
                        </td>
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            12/11/2026
                        </td>
                        <td></td>
                    </tr>
                    
                    <tr class="breakrow-inside breakrow-after">
                        <td rowspan="1" valign="top" style="padding: 10px 0 10px 5px;text-align: center;word-wrap: break-word;" class="pcs-item-row">
                            2
                        </td>

                        <td rowspan="1" valign="top" style="padding: 10px 0px 10px 20px;" class="pcs-item-row">
                            <div>
                                <div>
                                    <span style="word-wrap: break-word;" id="tmp_item_name">#INV001</span>
                                </div>
                            </div>
                        </td>
                        <td rowspan="1" valign="top" style="padding: 10px 0px 10px 20px; text-align:right;" class="pcs-item-row">15/12/2024</td>
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            Lorem ipsum doller sit amet.
                        </td>
                        <td rowspan="1" valign="top" style="padding: 10px 0px 10px 20px; text-align:right;" class="pcs-item-row">12</td>
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            10000.00
                        </td>
                        
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            #BILL6678904
                        </td>
                        
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            12/11/2025
                        </td>
                        <td rowspan="1" valign="top" style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;" class="pcs-item-row">
                            12/11/2026
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            
            
    
            
            <div style="width: 100%;margin-top: 1px;">
                <!--<div style="width: 45%;padding: 10px 10px 3px 3px;font-size: 9pt;float: left;">
                    <div style="white-space: pre-wrap;"></div>
                </div>-->
                <div>
                    <table class="pcs-totals" cellspacing="0" border="0" width="100%">
                        <tbody>
                            <!--<tr>
                                <td colspan="6" valign="middle" align="right" style="padding: 1px 10px 1px 0;">Total Quantity</td>
                                <td id="tmp_subtotal" valign="middle" align="right" style="width:120px;padding: 1px 10px 1px 5px;">20</td>
                            </tr>-->
                            <tr>
                                <td colspan="6" valign="middle" align="right" style="padding: 1px 10px 1px 0;">Total</td>
                                <td id="tmp_subtotal" valign="middle" align="right" style="width:120px;padding: 1px 10px 1px 5px;">10000</td>
                            </tr>
                            
                            <!--<tr>-->
                            <!--    <td colspan="6" valign="middle" align="right" style="padding: 1px 10px 1px 0;">Order Total</td>-->
                            <!--    <td id="tmp_subtotal" valign="middle" align="right" style="width:120px;padding: 1px 10px 1px 5px;">26260</td>-->
                            <!--</tr>-->


                            <!--<tr style="height:10px;">-->
                            <!--    <td colspan="6" valign="middle" align="right" style="padding: 1px 10px 1px 0;">Discount </td>-->
                            <!--    <td valign="middle" align="right" style="width:120px;padding: 1px 10px 1px 5px;"> 0.00 </td>-->
                            <!--</tr>-->


                            <!--<tr style="height:10px;">
                                <td valign="middle" align="right" style="padding: 5px 10px 5px 0;">CGST (9%) </td>
                                <td valign="middle" align="right" style="width:120px;padding: 10px 10px 10px 5px;">45.00</td>
                            </tr>
                            <tr style="height:10px;">
                                <td valign="middle" align="right" style="padding: 1px 10px 1px 0;">SGST (9%) </td>
                                <td valign="middle" align="right" style="width:120px;padding: 1px 10px 1px 5px;">45.00</td>
                            </tr>-->

                            


                            <!--<tr style="height:40px;" class="pcs-balance">-->
                            <!--    <td colspan="6" valign="middle" align="right" style="padding: 5px 10px 5px 0;" class="pcs-itemtable-header"><b>Amount Payable</b></td>-->
                            <!--    <td valign="middle" align="right" style="width:120px;padding: 10px 10px 10px 5px;" class="pcs-itemtable-header"><b>Rs. 26260</b></td>-->
                            <!--</tr>-->

                        </tbody>
                    </table>
                </div>
                <div style="clear: both;"></div>
            </div>
            <!--<div style="width: 100%;margin: 10px 0;">-->
            <!--    <table cellspacing="0" border="0" width="100%">-->
            <!--        <tbody>-->
            <!--            <tr>-->
            <!--                <td colspan="6" class="total-in-words-value text-align-left"><span style="margin-left: 41%;">Total In Words:<i><b>twenty six thousands two hundred  and sixty   Rupees   Only</b></i></span></td>-->
                                                        
            <!--            </tr>-->
            <!--        </tbody>-->
            <!--    </table>-->
            <!--    <div style="clear: both;"></div>-->
            <!--</div>-->
           

            <div style="page-break-inside: avoid;">
            </div>
            
            <div class="pcs-template-footer">
            <div class="pcs-footer-content">
                
                
               <div style="width: 49%; margin: 10px 0; display: inline-block;">
                    <table cellspacing="0" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="6" style="font-size: 14px; color: #000">
                                    <p style="font-size: 12px; color: #777; line-height:1.2; width:80%;margin-bottom: 0px;margin-top: 5px;"><span style="color: #000; font-size: 14px; font-weight: 600;">Caution :</span><br> We declare that the invoice shows the actual price
                                    of the goods described and the particulars are true and correct.
                                    This is a computer generated invoice.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="clear: both;"></div>
                </div>
                <div style="width: 49%; margin: 10px 0; display: inline-block;">
                    <table cellspacing="0" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="6" style="font-size: 14px; color: #000">
                                    <p style="font-size: 12px; color: #777; line-height:1.2; width:80%;margin-bottom: 0px;margin-top: 5px;"><span style="color: #000; font-weight: 600; font-size: 14px;">Notice :</span><br> We declare that the invoice shows the actual price
                                    of the goods described and the particulars are true and correct.
                                    This is a computer generated invoice.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>

        <div class="pcs-template-footer">
            <div class="pcs-footer-content">
                
                
               <div style="width: 49%; margin: 10px 0; display: inline-block;">
                    <table cellspacing="0" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="6" style="font-size: 14px; color: #000">
                                    <b>Signature of Consignor</b>
                                    <hr style="margin-top: 60px; width: 50%;margin-left: 2px;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="clear: both;"></div>
                </div>
                <div style="width: 49%; margin: 10px 0; display: inline-block;">
                    <table cellspacing="0" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td colspan="6" style="font-size: 14px; color: #000">
                                    <b>For of SR Logistics</b>
                                    <hr style="margin-top: 60px; width: 50%;margin-left: 2px;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="clear: both;"></div>
                </div>
            </div>
        </div>
        
        </div>

        

    </div>
</section>    
</div>
<!---->





<script>
function print_page()
{
   var divToPrint=document.getElementById("printble_table");
   newWin= window.open("");
   newWin.document.write(divToPrint.outerHTML);
   newWin.print();
   newWin.close();
   
   var head = '<html><head>' 
      + $("head").html() 
      + ' <style>body{background-color:white !important;}@page  { size: 21cm 14.8cm;margin: 1cm 1cm 1cm 1cm; }</style></head>';
   var body = '<body>'+divToPrint.outerHTML+'</body>';
   var pdf = head+body;
   
   newWin.document.write(pdf);
   newWin.print();
   newWin.close();
      
}
</script>
</body>
</html>