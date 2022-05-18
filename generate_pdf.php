<?php 
  //Step 2. Make a PHP file to generate PDF
  require 'vendor/autoload.php';
  use Dompdf\Dompdf;

  $ch = curl_init();
  // IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
  // in most cases, you should set it to true
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, 'https://www.posat-dubrovnik.com/cms/api/v2/test.php?lang=13');
  $result = curl_exec($ch);
  curl_close($ch);

  $path = 'header.png';
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path);
  $base641 = 'data:image/' . $type . ';base64,' . base64_encode($data);

  $obj = json_decode($result);
  $html="<div style='height: 1100.0px;' class='theader'><img src=".$base641."/></div>";
  $html.="<div class='page_break'></div><div class='tdiv'><table align=center>";
  for ($i=0;$i<count($obj);$i++) {
            if ($i==4||$i==7)
              $html.="<div class='page_break'></div>";
            $html .="<tr>".
                "<th colspan='2' class='t-title'>".strtoupper($obj[$i]->title)."</th>".
                '</tr>';
            for ($j=0;$j<count($obj[$i]->items);$j++) {
                if ($i==2&&$j==11)
                  $html.="<br/><br/>";
                else if ($i==6&&$j==2)
                  $html.="<br/><br/>";
                else if ($i==6&&$j==14)
                  $html.="<br/><br/>";
                else if ($i==7&&$j==11)
                  $html.="<br/><br/>";
                $html .="<tr>"."<td class='t_title'>".$obj[$i]->items[$j]->naziv."</td>"."<td class='t_price'>".$obj[$i]->items[$j]->cijena." kn</td>".'</tr>'.'<tr>'."<td colspan='2' class='t_amount'>".$obj[$i]->items[$j]->normativ."</td>".'</tr>';
            }
        }
  $html.="</table></div><div class='page_break1'></div>";


  $path = 'footer.png';
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path);
  $base642 = 'data:image/' . $type . ';base64,' . base64_encode($data);

  $html.="<div style='height: 1010.0px;' class='tfooter'><img src=".$base642."/></div>";


  $path = 'background.png';
  $type = pathinfo($path, PATHINFO_EXTENSION);
  $data = file_get_contents($path);
  $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


  $html.="<style>
  @page {margin: 0px 0px 0px 0px ; padding: 0px 0px 0px 0px ;}
  body { 
    background-image: url(".$base64.");
    background-size:100%;
    padding-top:230px;
    padding-bottom:120px;
  }
  .t-title {
  }
table {
    width: 90%;
}
.theader {
  top: 0px;
  position: absolute;
}
.tfooter {
  top: 0px;
  position: absolute;
}
.tdiv {
}
  .page_break { page-break-before: always; }
  .page_break1 { page-break-after: always; }
}
td
{
  margin:0px; padding:0px;
 font-family: 'cardopro'; font-weight: normal; src: url(\'fonts/Cardo-Regular.ttf\') format(\'truetype\');
  border-collapse: collapse;
}
th
{
 padding-top:20px;
 padding-bottom:25px;
 letter-spacing: 5pt;
 font-size:25px;
 font-family: 'cardopro'; font-weight: normal; src: url(\'fonts/Cardo-Bold.ttf\') format(\'truetype\');
}
.t_title
{
 font-size:16px;
 color:rgb(125,50,63);
}
.t_price
{
 text-align: right;
 font-size:17px;
 color:black;
}
.t_amount
{
  padding-left:10px;
position:relative;
 font-size:14px;
 color:grey;
}</style>";
  $dompdf = new Dompdf(); 
  $dompdf->loadHtml($html);
  $dompdf->setPaper('A4', 'portrait');
  $dompdf->render();

  $dompdf->stream("niceshipest",array("Attachment" => false));
  exit(0);
?>
