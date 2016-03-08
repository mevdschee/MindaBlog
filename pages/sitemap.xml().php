<?php
$data = DB::select('select slug, modified from posts where published is not null and published < NOW() order by published');
