<h1>Dashboard</h1>
<?php
$holidays = [];
for ($i = 0; $i < 30; $i++) {
    $holidays[] = date("Y-m-d", strtotime("+{$i} week friday"));
}
print_r($holidays);
echo Yii::getAlias('@apiimages');
?>