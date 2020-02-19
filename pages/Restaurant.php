<?php
/**
 * レストランクラス
 */
class Restaurant {
	/**
	 * 属性
	 * @var int    $id     レストランID
	 * @var string $name   レストラン名
	 * @var string $detail レストラン詳細（レストランの説明）
	 * @var string $image  レストランの画像
	 * @var int    $area   レストランの所在地域
	 */
	private $id;
	private $name;
	private $detail;
	private $image;
	private $area;

	/**
	 * コンストラクタ
	 * @param int    $id     レストランID
	 * @param string $name   レストラン名
	 * @param string $detail レストラン詳細（レストランの説明）
	 * @param string $image  レストランの画像
	 * @param int    $area   レストランの所在地域
	 */
	function __construct(int $id, string $name, string $detail, string $image, int $area) {
		$this->id = $id;
		$this->name = $name;
		$this->detail = $detail;
		$this->image = $image;
		$this->area = $area;
	}

	/**
	 * アクセサメソッド群
	 */
	function getId():int {
		return $this->id;
	}
	function setId(int $id):void {
		$this->id = $id;
	}
	function getName():string {
		return $this->name;
	}
	function setName(string $name):void {
		$this->name = $name;
	}
	function getDetail():string {
		return $this->detail;
	}
	function setDetail(string $detail):void {
		$this->detail = $detail;
	}
	function getImage():string {
		return $this->image;
	}
	function setImage(string $image):void {
		$this->image = $image;
	}
	function getArea():int {
		return $this->area;
	}
	function setArea(int $area):void {
		$this->area = $area;
	}
}
?>