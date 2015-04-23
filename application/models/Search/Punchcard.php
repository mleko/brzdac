<?php

/**
 *
 * @author mleko
 */
class Search_Punchcard {

	protected $punchcard = null;

	protected function __construct($punchcard) {
		$this->punchcard = $punchcard;
	}

	/**
	 *
	 * @param type $uptimeList
	 * @return Search_Punchcard
	 */
	static public function fromUptimeList($uptimeList) {
		$punchcard = array();
		for($d = 0; $d < 7; $d++) {
			for($h = 0; $h < 24; $h++) {
				$punchcard[$d][$h] = 0;
			}
		}

		foreach($uptimeList as $row) {
			$punchcard[$row['dow']][$row['hour']] = $row['ratio'];
		}

		return new self($punchcard);
	}

	public function generateSVG($dayLabels, $fieldSize) {
		$out = '';
		$height = 7.5 * $fieldSize + 2;
		$width = 24.5 * $fieldSize + 3;
		/* header */
		$out .= "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 $width $height' width='1000' style='border: 1px black solid;'>\n";
		$out .= "<rect x='0' y='0' width='$width' height='$height' style='fill: white' />\n";
		$out .="<title>Punchcard</title>\n<text font-size='10' x='" . ($width / 2 - 10 * 1.7 ) . "' y='-5'>Punchcard</text>\n";

		/* horizontal stripes */
		for($d = 0; $d < 7; $d++) {
			$y = $d * $fieldSize;
			if(!($d % 2)) {
				$out .= "<rect x='0' y='$y' width='$width' height='$fieldSize' style='fill: #99f' fill-opacity='0.1'/>\n";
			}
		}
		/* vertical stripes */
		for($h = 0; $h < 24; $h++) {
			$x = (($h) * $fieldSize + $fieldSize / 2) + 2;
			if(!($h % 2)) {
				$out .= "<rect x='$x' y='-1' width='$fieldSize' height='" . ($height + 2) . "' style='fill: #eef' fill-opacity='0.05' stroke='#eee' stroke-width='.001'/>\n";
			}
		}
		/* day labels, uptime circles */
		for($d = 0; $d < 7; $d++) {
			$out .= "<text font-size='3' x='2' y='" . ($d * $fieldSize + $fieldSize / 2 + 2) . "'>{$dayLabels[$d]}</text>\n";
			for($h = 0; $h < 24; $h++) {
				if($this->punchcard[$d][$h]) {
					$out .= "<circle fill='#333' cx='" . (($h + 1) * $fieldSize + 2) . "' cy='" . ($d * $fieldSize + $fieldSize / 2) . "' r='" . ($this->punchcard[$d][$h] * 5) . "'>"
							. "<title>" . sprintf("%.2f%%", $this->punchcard[$d][$h] * 100) . "</title></circle>\n";
				}
			}
		}
		/* hour labels */
		for($h = 0; $h < 24; $h++) {
			$x = (($h + 1) * $fieldSize - 2);
			$hh = str_pad($h, 2, "0", STR_PAD_LEFT);
			$out .= "<text font-size='3' x='$x' y='" . (7.5 * $fieldSize) . "'>$hh:00</text>\n";
		}
		$out .= '</svg>';
		return $out;
	}

}
