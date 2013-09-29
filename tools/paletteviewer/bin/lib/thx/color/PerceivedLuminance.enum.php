<?php

class thx_color_PerceivedLuminance extends Enum {
	public static $Perceived;
	public static $PerceivedAccurate;
	public static $Standard;
	public static $__constructors = array(1 => 'Perceived', 2 => 'PerceivedAccurate', 0 => 'Standard');
	}
thx_color_PerceivedLuminance::$Perceived = new thx_color_PerceivedLuminance("Perceived", 1);
thx_color_PerceivedLuminance::$PerceivedAccurate = new thx_color_PerceivedLuminance("PerceivedAccurate", 2);
thx_color_PerceivedLuminance::$Standard = new thx_color_PerceivedLuminance("Standard", 0);
