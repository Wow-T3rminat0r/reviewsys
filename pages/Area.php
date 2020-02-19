<?php
/**
 * 地域クラス
 */
class Area {
	/**
	 * 属性
	 * @var int    $id   地域ID
	 * @var string $name 地域名
	 */
	private $id;
	private $name;

	/**
	 * コンストラクタ
	 * @param int    $id   地域ID
	 * @param string $name 地域名
	 */
	function __construct(int $id, string $name) {
		$this->id = $id;
		$this->name = $name;
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

}
?>