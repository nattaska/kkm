<head>
    <style type="text/css" media="print">
    @page
        {
            size: auto;   /* กำหนดขนาดของหน้าเอกสารเป็นออโต้ครับ */
            margin: 0 0 0 0mm;  /* กำหนดขอบกระดาษเป็น 0 มม. */
            font-size:10px;
        }
    body
        {
            size: auto;
            margin: 0 0 0 0px;  /* เป็นการกำหนดขอบกระดาษของเนื้อหาที่จะพิมพ์ก่อนที่จะส่งไปให้เครื่องพิมพ์ครับ */
            font-size:10px;
        }
    </style>
</head>
<body bgcolor=#FFFFFF topmargin=0 leftmargin=0>
<div align=center>
<table border="0" width="300" height="200">
<caption align="top"><font size="4"><B> Order Date : <?php echo $this->orddate; ?> </B></font></caption>
<tr><td></br></td><td></td><td></td></tr>
<?php
// print_r($this->items);
foreach ($this->items as $item) {
    echo '<tr>  
            <td align="left"> &emsp; <font size="2">'.$item['item'].' </font></td>   
            <td align="left"><font size="2"> '.$item['qty'].' </font></td>  
            <td>&emsp;&emsp;&emsp;&emsp;&ensp;</td>  
        </tr>';
}
?>
</table>
</div>
</body>
