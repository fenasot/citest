apexscore = () => {
	let total = 0;
	const i = json.length;
	counter = (a) => {
		if (a < i) {
			total += jsondecode(a);
			return counter(a + 1);
		} else {
			return total;
		}
	};
	let mathcount = counter(0);
	let chinesecount = counter(0);
	let englishcount = counter(0);

	totalcount = totalcounter = () => {
		return (mathcount + chinesecount + englishcount) / 3;
	};
};

$.ajax({
	url: "http://localhost/get", // PHP 腳本的 URL
	success: function (data) {
		console.log(data); // 從 PHP 返回的數據
	},
});
