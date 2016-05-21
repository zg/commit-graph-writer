<?php
$pattern = array();
$pattern_flipped = array();
date_default_timezone_set('America/New_York');
$day = strtotime(date('Y-m-d',time()).' - 52 weeks - 1 day');
foreach(explode("\n",file_get_contents('pattern.txt')) as $day_of_week => $line)
    $pattern[] = str_split($line,1);
while(count($pattern)>0)
{
    $pattern_flipped[count($pattern[0])-1][] = array_shift($pattern[0]);
    if(count($pattern[0]) == 0)
         array_shift($pattern);
}

$day = strtotime(date('Y-m-d',time()).'-'.(51*7+1).' days');
$cursor = 0;
echo date('Y-m-d',$day);
foreach($pattern_flipped as $week) {
    foreach($week as $day) {
        if($day == "#") {
            for($i = 0; $i < 100; $i++) {
                $day = date('Y-m-d\T12:00',strtotime(date('Y-m-d',time()).'-'.(51*7+1-$cursor).' days'));
                echo "GIT_AUTHOR_DATE='$day' GIT_COMMITTER_DATE='$day' git commit --allow-empty --allow-empty-message -m ''\n";
                exec("GIT_AUTHOR_DATE='$day' GIT_COMMITTER_DATE='$day' git commit --allow-empty --allow-empty-message -m ''");
            }
        }
        $cursor++;
    }
}
