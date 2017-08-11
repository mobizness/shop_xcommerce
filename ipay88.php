<?PHP
//// Response
$merchantcode = $_REQUEST["MerchantCode"];
$paymentid = $_REQUEST["PaymentId"];
$refno = $_REQUEST["RefNo"];
$amount = $_REQUEST["Amount"];
$ecurrency = $_REQUEST["Currency"];
$remark = $_REQUEST["Remark"];
$transid = $_REQUEST["TransId"];
$authcode = $_REQUEST["AuthCode"];
$estatus = $_REQUEST["Status"];
$errdesc = $_REQUEST["ErrDesc"];
$signature = $_REQUEST["Signature"];

//////// function for making sigature
function iPay88_signature($source)
{
  return base64_encode(hex2bin(sha1($source)));
}

if (!function_exists('hex2bin')){
	function hex2bin($hexSource)
	{
		for ($i=0;$i<strlen($hexSource);$i=$i+2)
		{
		  $bin .= chr(hexdec(substr($hexSource,$i,2)));
		}
	  return $bin;
	}
}
$sign = iPay88_signature('cRFkKfG6nNM07662A00000001100MYR');
?>

<form name="ePayment" action="https://www.mobile88.com/ePayment/entry.asp" method="post">
    <input type="hidden" name="MerchantCode" value="M07662" />
    <input type="hidden" name="RefNo" value="A00000001" />
    <input type="hidden" name="PaymentId" value="" />
    <input type="hidden" name="Amount" value="1.00" />
    <input type="hidden" name="Currency" value="MYR" />
    <input type="hidden" name="ProdDesc" value="LCD" />
    <input type="hidden" name="UserName" value="sag" />
    <input type="hidden" name="UserEmail" value="deepak@sagipl.com" />
    <input type="hidden" name="UserContact" value="987654321" />
    <input type="hidden" name="Remark" value="" />
    <input type="hidden" name="Lang" value="UTF-8" />
    <input type="hidden" name="Signature" value="<?php echo $sign;?>" />	
    <input type="hidden" name="ResponseURL" value="http://shop.tbm.com.my/ipay88.php" />
    <input type="hidden" name="BackendURL" value="http://shop.tbm.com.my/ipay88.php" />
    <input type="submit" name="Submit" value="Proceed with Payment" />
</form>