<?php
require_once "Area.php";
require_once "Restaurant.php";
require_once "Review.php";
?>
<?php
/**
 * 地域配列を生成する。
 * @return array Areaクラスのインスタンスを要素とする配列
 */
function createAreas() {
	$areas = [];

	$area = new Area(1, "福岡");
	$areas[] = $area;
	
	$area = new Area(2, "神戸");
	$areas[] = $area;
	
	$area = new Area(3, "伊豆");
	$areas[] = $area;

	return $areas;
	
}

/**
 * レストラン配列を生成する。
 * @return array Restaurantクラスのインスタンスを要素とする配列
 */
function createRestaurants():array {
	$restaurants = [];

	$restaurant = new Restaurant(1, "Wine Bar ENOTECA", "常時10種類以上の赤・白ワインをご用意しています。\n記念日にご来店ください。", "restaurant_1.jpg", 2);
	$restaurants[] = $restaurant;
	
	$restaurant = new Restaurant(2, "スペイン料理 ポルファボール！", "味が自慢。スペイン現地で学んだシェフが出す味は本物です。", "restaurant_2.jpg", 3);
	$restaurants[] = $restaurant;
	
	$restaurant = new Restaurant(3, "パス・パスタ", "本当のパスタを味わうならパス・パスタで！\n休日の優雅なランチタイムに是非どうぞ。", "restaurant_3.jpg", 1);
	$restaurants[] = $restaurant;
	
	$restaurant = new Restaurant(4, "レストラン「有閑」", "広い店内で、お昼の優雅なひと時を過ごしませんか？", "restaurant_4.jpg", 2);
	$restaurants[] = $restaurant;
	
	$restaurant = new Restaurant(5, "ビストロ「ルーヴル」", "高層ビル42階のビストロで、県内が一望できる。恋人とのひと時をここで過ごしませんか。", "restaurant_5.jpg", 1);
	$restaurants[] = $restaurant;
	
	$restaurant = new Restaurant(6, "海沿いのレストラン La Mer", "海が見える、海沿いのレストランです。", "restaurant_6.jpg", 2);
	$restaurants[] = $restaurant;
	
	$restaurant = new Restaurant(7, "レストラン さくら", "四季折々の自然を楽しむ伊豆市に、ひっそりと佇む隠れ家レストラン。\n旅行でいらっしゃった方も、お近くの方も、お気軽にお立ち寄りください。", "restaurant_7.jpg", 3);
	$restaurants[] = $restaurant;

	return $restaurants;
	
}

// 手順-4：レビュクラスを要素とする配列を生成
function createReviews(){
	$reviews = [];

	$review = new Review(1, 7, "totsuka", "常連の者で、いつも夫婦で伺っています。席数が少ないので予約した方が安心ですが、その分落ち着いて食事できますよ。コースのメインは基本的にシェフにお任せ。来るたびに、新しい味との出会いを楽しめるお店です。", 4);
	$reviews[] = $review;

	$review = new Review(2, 7, "oie", "説明の通り、喧騒を外れた場所にひっそりとあるレストランでした。伊豆市には初めて来ましたが、本当に桜がきれいですね。何よりも空気がきれいで、いいリフレッシュになりました。", 5);
	$reviews[] = $review;

	return $reviews;

}
?>