<!--
Copyright (c) 2010 Shawn M. Douglas (shawndouglas.com)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
-->

<?php
echo "<html>
<head><title>Excel xls to wiki copy and paste converter for wikipedia and mediawiki</title></head>
<body><h1>Copy & Paste Excel-to-Wiki Converter</h1>
<form action='index.php' method='post'><textarea name='data' rows='10' cols='50'></textarea><br /><input type='submit' /><input type='checkbox' name='header' checked='checked'> format header<br />
<input type='checkbox' name='first_row'> first column has link [ optional: subpage to <input type='text' name='sistem' /> ]
<br />
<input type='checkbox' name='empty_cell'> add empty <input type='text' name='noOfcell' size='5' /> cell(s)</form>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') :

echo "<h2>result</h2>\n<pre>\n{| class=\"wikitable\"\n";
$lines = preg_split("/\n/", $_POST['data']);
$n = sizeof($lines);

foreach ($lines as $index => $value):
 
 $line = preg_split("/\t/", $value);

 if ($index == 0 && isset($_POST['header'])):
  echo "|-\n!";
 	 foreach ($line as $val) :
  		$val2 = rtrim($val);
   		echo $val2. '!!' ;
		if(isset($_POST['empty_cell']) && isset($_POST['noOfcell']))
		for($i=0;$i<($_POST['noOfcell']-1);$i++)
		echo ' new cell!!';
  	 endforeach;
  echo "\n";
  echo "|-\n";
 
 else :

	if(isset($_POST['first_row'])):
		if(isset($_POST['sistem']) && $_POST['sistem'] != ''):
		$line[0] = "[[".$_POST['sistem']."/".trim($line[0])."|".trim($line[0])."]]";	
		else:		
		$line[0] = "[[".trim($line[0])."|".trim($line[0])."]]";
		endif;
	endif;

  $data = implode("||", $line);
  echo '| ' . $data;
		if(isset($_POST['empty_cell']) && isset($_POST['noOfcell']))
		for($i=0;$i<$_POST['noOfcell'];$i++)
		echo ' ||';
  	if ($index < $n - 1) : echo "\n|-\n";  endif;
 endif;

endforeach;

echo "\n|}</pre>";


else : //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
echo "<small><b>Instructions:</b><br><br>
1. Copy & paste cells from Excel and click submit. Paste results into wikipedia or similar wiki.<br><br></small>";
endif;

echo "</body></html>";

?>