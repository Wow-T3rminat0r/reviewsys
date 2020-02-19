<?php
/** 外部ファイルの読込み */
require_once "Restaurant.php";	// レストランクラスの読込み
require_once "Area.php";				// 地域クラスの読込み
require_once "funx.php";				// 関数定義ファイルの読込み
?>
<?php
// リクエストパラメータを取得
$selectedArea = null;
if (isset($_REQUEST["area"])) $selectedArea = intval($_REQUEST["area"]);

/** 手順-1：データベースに接続 */
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

/** 手順-2：地域テーブルのレコードを取得 */
// SQLを設定
$sql = "select * from areas";
// SQL実行オブジェクトを取得
$pstmt = $pdo->prepare($sql);
// SQLの実行
$pstmt->execute();
// 結果を地域の配列に変換
$areas = [];
while ($rs = $pstmt->fetch(PDO::FETCH_ASSOC)) {
	$id = $rs["id"];
	$name = $rs["name"];
	$area = new Area($id, $name);
	$areas[] = $area;
}

/** 手順-3、手順-4：レストランテーブルのレコードを取得 */
	if (!isset($selectedArea) or $selectedArea === 0) {
	/* 手順-3：すべてのレコードを取得する場合 */
	// SQLを設定
	$sql = "select * from restaurants";
	// SQL実行オブジェクトを取得
	$pstmt = $pdo->prepare($sql);
} else {
	/* 手順-4：指定された地域のレストランを取得する場合：PDOStatement::bindValueメソッドによるオーソドックスな方法の場合 */
	// SQLを設定
	$sql = "select * from restaurants where area = ?";
	// SQL実行オブジェクトを取得
	$pstmt = $pdo->prepare($sql);
	// プレースホルダにリクエストパラメータを設定
	$pstmt->bindValue(1, $selectedArea, PDO::PARAM_INT);
}
// SQLの実行と結果セットの取得
$pstmt->execute();
$rs = $pstmt->fetchAll();
// 結果セットからレストランクラスの配列に変換
$restaurants = [];
foreach ($rs as $record) {
	$id = $record["id"];
	$name = $record["name"];
	$detail = $record["detail"];
	$image = $record["image"];
	$area = $record["area"];
	$restaurant = new Restaurant($id, $name, $detail, $image, $area);
	$restaurants[] = $restaurant;
}

/* データベース関連オブジェクトの破棄：インスタンス化した順と逆順に破棄する */
unset($pstmt);
unset($pdo);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<title>レストラン一覧 - レストラン・レビュ・サイト</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/list.css" />
</head>

<body id="list">
	<header>
		<h1><a href="list.php">レストラン・レビュ・サイト</a></h1>
	</header>
	<main>
		<div class="clearfix">
			<h2>レストラン一覧</h2>
			<form action="list.php" name="search_form" method="get">
				<!-- 地域選択リストボックス -->
				<select name="area">
					<option value="0"> -- 地域を選んで下さい -- </option>
					<!-- 手順-5：連想配列からクラスへの変更に伴う修正 -->
					<?php foreach ($areas as $area) { ?>
					<option value="<?= $area->getId() ?>"><?= $area->getName() ?></option>
					<?php } ?>
				</select>
				<input type="submit" value="検索" />
			</form>
		</div><!-- /.clearfix -->
		<table class="list">
			<!-- 手順-5：連想配列からクラスへの変更に伴う修正 -->
			<?php foreach ($restaurants as $restaurant) { ?>
			<tr>
				<td class="photo"><img width="110" alt="「<?= $restaurant->getName() ?>」の写真" src="../pages/img/<?= $restaurant->getImage() ?>" /></td>
				<td class="info">
					<dl>
						<dt><?= $restaurant->getName() ?></dt>
						<dd><?= $restaurant->getDetail() ?></dd>
					</dl>
				</td>
				<td class="detail"><a href="detail.php?id=<?= $restaurant->getId() ?>">詳細</a></td>
			</tr>
					<?php } ?>
		</table>
	</main>
	<footer>
		<div id="copyright">(C) 2019 The Web System Development Course</div>
	</footer>
</body>

</html>