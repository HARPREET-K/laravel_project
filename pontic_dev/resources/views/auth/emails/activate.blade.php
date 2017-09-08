<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	background-color: #EEE;
}
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="20" bgcolor="#EEE">
  <tr>
    <td  ><table width="600" border="0" align="center" cellpadding="20" cellspacing="0" style="font-family: 'Roboto', sans-serif;">
  <tr>
    <td align="center" valign="middle"  ><img src="{{secure_url('images/logo-login.png') }}" /></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF" style="border-radius: 3px;"><table width="100%" border="0" cellspacing="0" cellpadding="10" style="color:#333333;">
      <tr>
        <td align="center" style="font-size:24px;">
        Hi {{ $name }},   
</br>
		Welcome to Pontic !!!
        </td>
      </tr>
      <tr>
        <td align="center">To proceed using our website, please verify your email by clicking the below button.</td>
      </tr>
      <tr>
        <td height="50" align="center"><a href="{{ $link }}" style="clear:both; background-color:#32466f; color:#FFF; text-decoration:none; padding:10px 30px; border-radius: 3px;">Verify</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="middle"   style="color:#000;">All rights reserved @ Pontic - 2016</td>
  </tr>
</table></td>
  </tr>
</table>


</body>
</html>
