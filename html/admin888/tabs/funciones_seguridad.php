<?php

function seg($campo)
{
return addslashes(mysql_real_escape_string($campo));
}
