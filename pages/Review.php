<?php
// 手順-3：レビュクラスの定義
/**
 * レビュクラス
 */
class Review {
	/**
	 * 属性
	 * @var int    $id           レビュID
	 * @var int    $restaurantId レストランID
	 * @var string $reviewer     投稿者
	 * @var string $comment      投稿コメント
	 * @var int    $point        評価ポイント
	 */
	private $id;
	private $restaurantId;
	private $reviewer;
	private $comment;
	private $point;

	/**
	 * コンストラクタ
	 * @param int    $id           レビュID
	 * @param int    $restaurantId レストランID
	 * @param string $reviewer     投稿者
	 * @param string $comment      投稿コメント
	 * @param int    $point        評価ポイント数
	 */
	function __construct(int $id, int $restaurantId, string $reviewer, string $comment, int $point) {
		$this->id = $id;
		$this->restaurantId = $restaurantId;
		$this->reviewer = $reviewer;
		$this->comment = $comment;
		$this->point = $point;
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

	function getRestaurantId():int {
		return $this->restaurantId;
	}
	function setRestaurantId(int $id):void {
		$this->restaurantId = $id;
	}

	function getReviewer():string {
		return $this->reviewer;
	}
	function setReviewer(string $reviewer):void {
		$this->reviewer = $reviewer;
	}

	function getComment():string {
		return $this->comment;
	}
	function setComment(string $comment):void {
		$this->comment = $comment;
	}

	function getPoint():int {
		return $this->point;
	}
	function setPoint(int $point):void {
		$this->point = $point;
	}

	/**
	 * 評価ポイントを星印文字列に変換する。
	 * @return string 評価ポイントの数だけ「★」をつけ、全体で5文字になるように残りを「☆」で埋めた文字列
	 * 								例）評価ポイント２の場合：★★☆☆☆
	 */
	function createStars():string {
		$maxLength = 5;	// 最大文字列長：本来これはクラス定数とするべきだが、講義では定数を説明していないので変数として代用
		$stars = "";
		for ($i = 0; $i < $maxLength; $i++) {
			if ($i < $this->point ) {
				$stars .= "★";
			} else {
				$stars .= "☆";
			}
		}
		return $stars;
	}

}
?>