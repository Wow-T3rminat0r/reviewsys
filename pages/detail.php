<?php
// 外部ファイルの読込み
require_once "Restaurant.php";
require_once "funx.php";
?>
<?php
/* リクエストパラメータを取得 */
$restaurantId = null;
if (isset($_REQUEST["id"])) $restaurantId = intval($_REQUEST["id"]);
/** 手順-7：［投稿］ボタンが押されたときはリクエストパラメータにpointキーが存在する */
$reviewer = "";
$comment = "";
$point = -1;
if(isset($_REQUEST["reviewer"])) $reviewer = $_REQUEST["reviewer"];
if(isset($_REQUEST["comment"])) $comment = $_REQUEST["comment"];
if(isset($_REQUEST["point"])) $point = intval($_REQUEST["point"]);

/* データベースに接続 */
// データベース接続文字列を設定
$dsn  = "mysql:host=localhost;dbname=reviewdb";
$user = "reviewdb_admin";
$password = "admin123";
try {
	//データベース接続オブジェクトを取得
	$options=array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'");
	//PDOの呼び出し
	$pdo=new PDO("mysql:host=localhost;dbname=reviewdb","reviewdb_admin","admin123",$options);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo $e->getMessage();
}

/** 手順-7：［投稿］ボタンが押されたときの処理（投稿処理） */
if ($point > 0) {
	/* ［投稿］ボタンが押された場合は評価ポイントが必ず送信される：評価ポイントはデフォルト値があるため */
	// SQLを設定：名前付きプレースホルダを利用
	$sql = "insert into reviews (restaurant, comment, reviewer, rating) values (:restaurant, :comment, :reviewer, :rating)";
	// SQL実行オブジェクトを取得
	$pstmt = $pdo->prepare($sql);
	// プレースホルダ設定用の連想配列を設定：プレースホルダ名をキー、対応するリクエストパラメータを値とする連想配列を設定する。
	$params = [];
	$params[":restaurant"] = $restaurantId;
	$params[":comment"] = $comment;
	$params[":reviewer"] = $reviewer;
	$params[":rating"] = $point;
	// SQLの実行：テーブルの状態を変更するSQLを実行するだけなので結果セットは必要ない。
	$pstmt->execute($params);
}

/** 手順-5：リクエストパラメータで指定されたレストランを取得 */
// SQLを設定
$sql = "select * from restaurants where id = :id";
// SQLを設定：名前付きプレースホルダを利用
$pstmt = $pdo->prepare($sql);
// プレースホルダ設定用の連想配列を設定：プレースホルダ名をキー、対応するリクエストパラメータを値とする連想配列を設定する。
$params = [];
$params[":id"] = $restaurantId;
// SQLの実行と結果セットの取得：主キーでの抽出なので1件または0件抽出されるはずなのでPDOStatement::fetchメソッドで結果セットを取得
$pstmt->execute($params);
$rs = $pstmt->fetch(PDO::FETCH_ASSOC);
// 結果セットをレストランクラスのオブジェクトに変換
$restaurant = null;
if (!is_null($rs)) {
	$id = $rs["id"];
	$name = $rs["name"];
	$detail = $rs["detail"];
	$image = $rs["image"];
	$area = $rs["area"];
	$restaurant = new Restaurant($id, $name, $detail, $image, $area);
}

/** 手順-6：レビュテーブルから指定されたレストランIDのレビュを取得 */
// SQLを設定
$sql = "select * from reviews where restaurant = :id";
// SQL実行オブジェクトを取得
$pstmt = $pdo->prepare($sql);
// プレースホルダ設定用の連想配列を設定：プレースホルダ名をキー、対応するリクエストパラメータを値とする連想配列を設定する。
$conditions[":id"] = $restaurantId;
// SQLの実行と結果セットの取得
$pstmt->execute($conditions);
$rs = $pstmt->fetchAll();
// 結果セットからレビュクラスの配列に変換
$reviews = null;
foreach ($rs as $record) {
	$id = $record["id"];
	$restaurantId = $record["restaurant"];
	$comment = $record["comment"];
	$reviewer = $record["reviewer"];
	$rating = $record["rating"];
	$review = new Review($id, $restaurantId, $reviewer, $comment, $rating);
	$reviews[] = $review;
}

/* データベース関連オブジェクトの破棄：インスタンス化した順と逆順に破棄する */
unset($pstmt);
unset($pdo);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<title>レストラン詳細情報 - レストラン・レビュ・サイト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/detail.css" />
</head>

<body id="detail">
	<header>
		<h1><a href="list.php">レストラン・レビュ・サイト</a></h1>
	</header>
	<main>
		<article id="description">
			<h2>レストラン詳細</h2>
			<table class="list">
				<tr>
					<!-- 手順-5：取得したレストランの情報を表示 -->
					<td class="photo"><img width="110" alt="「<?= $restaurant->getName() ?>」の写真" src="../pages/img/<?= $restaurant->getImage() ?>" /></td>
					<td class="info">
						<dl>
							<dt><?= $restaurant->getName() ?></dt>
							<dd><?= $restaurant->getDetail() ?></dd>
						</dl>
					</td>
				</tr>
			</table>
		</article>
		<article id="reviews">
			<h2>レビュ一覧</h2>
			<!-- 手順7：レビュの配列の構造が変わるので要素数で判断する -->
			<?php if (!is_null($reviews)) { ?>
			<?php 	foreach ($reviews as $review) { ?>
			<dl>
				<!-- <dt><?= $review->getPoint() ?>★★★★☆</dt> -->
				<dt><?= $review->createStars() ?></dt>
				<dd><?= $review->getComment() ?>（<?= $review->getReviewer() ?>）</dd>
			</dl>
			<?php 	} ?>
			<?php } ?>
			<!--
			<dl>
				<dt>★★★★☆</dt>
				<dd>常連の者で、いつも夫婦で伺っています。席数が少ないので予約した方が安心ですが、その分落ち着いて食事できますよ。コースのメインは基本的にシェフにお任せ。来るたびに、新しい味との出会いを楽しめるお店です。（totsuka）</dd>
			</dl>
			<dl>
				<dt>★★★★★</dt>
				<dd>説明の通り、喧騒を外れた場所にひっそりとあるレストランでした。伊豆市には初めて来ましたが、本当に桜がきれいですね。何よりも空気がきれいで、いいリフレッシュになりました。（oie）</dd>
			</dl>
			-->
		</article>
		<article id="review">
			<h2>レビュを書き込む</h2>
			<form name="review_form" action="detail.php" method="post">
				<!-- 手順-7：投稿の際にレストランIDがないと、レビュテーブルに登録できないためhiddenで持たせる。 -->
				<input type="hidden" name="id" value="<?= $restaurantId ?>" />
				<table class="review">
					<tr>
						<th>お名前</th>
						<td><input type="text" name="reviewer" /></td>
					</tr>
					<tr>
						<th>ポイント</th>
						<td>
							<input type="radio" name="point" value="1" id="1" />
							<label for="1">1</label>
							<input type="radio" name="point" value="2" id="2" />
							<label for="2">2</label>
							<input type="radio" name="point" value="3" id="3" checked />
							<label for="3">3</label>
							<input type="radio" name="point" value="4" id="4" />
							<label for="4">4</label>
							<input type="radio" name="point" value="5" id="5" />
							<label for="5">5</label>
						</td>
					</tr>
					<tr>
						<th>レビュ</th>
						<td><textarea name="comment"></textarea></td>
					</tr>
				</table>
				<input type="submit" value="投稿" />
				<input type="reset" value="クリア" />
			</form>
		</article>
	</main>
	<footer>
		<div id="copyright">(C) 2019 The Web System Development Course</div>
	</footer>
</body>

</html>