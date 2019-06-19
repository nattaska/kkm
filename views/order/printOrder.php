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
<caption align="center"><font size="5"><B> Order Date : <?php echo $this->orddate; ?> </B></font></caption>
<tr><td></br></td><td></td><td></td><td></td></tr>
<?php
// print_r($this->items);
$oldLocation = "0";
$white = "FFFFFF";
$color = $white;
foreach ($this->items as $item) {
    if ($oldLocation != $item['location']) {
        if ($color === $white) {
            $color = "9FE5C4";
        } else {
            $color = $white;
        }
    }

    echo '<tr bgcolor="#'.$color.'">  
            <td align="left"><font size="3">'.$item['item'].' </font></td>   
            <td align="left"><font size="3"> '.$item['qty'].' </font></td>  
            <td>&emsp;&emsp;&ensp;</td>  
            <td align="right"><font size="3"> '.$item['price'].' </font></td>  
          </tr>';
    $oldLocation = $item['location'];
}
?>
</table>
</div>
</body>
