//
//
//
// These is custom setting.
// Let tooltip can be listened by js.
const tooltipwindow = document.getElementsByClassName("apexcharts-tooltip");
const tooltiplabel = document.getElementsByClassName(
	"apexcharts-tooltip-series-group"
);
tooltipwindow[0].style.pointerEvents = "auto";

// Let tooltip window keeping display.
const outputer = () => {
	tooltipwindow[0].style.opacity = "1";
	//tooltipwindow[0].style.transition = ".15s ease all";
};
const removeoutputer = () => {
	tooltipwindow[0].style.opacity = "";
	//tooltipwindow[0].style.transition = "";
};
const labeloutputer = (classnumber) => {
	console.log(classnumber);
	console.log("test");
	const closealltooltip = (classnum) => {
		if (classnum != 0) {
			tooltiplabelwindow[classnum].style.opacity = "";

			return closealltooltip(classnum - 1);
		}
	};
	closealltooltip(2);
	tooltiplabelwindow[classnumber].style.opacity = "1";
};

const labelremoveoutputer = (classnumber) => {
	tooltiplabelwindow[classnumber].style.opacity = "";
};
tooltipwindow[0].addEventListener("mouseenter", () => {
	setTimeout(outputer, 50);
});

// Used to listener tooltip's moveout and moveleave events.
tooltipwindow[0].addEventListener("mouseleave", removeoutputer);
tooltiplabel[0].addEventListener("mouseenter", () => {
	setTimeout(() => labeloutputer(0), 50);
});
tooltiplabel[1].addEventListener("mouseenter", () => {
	setTimeout(() => labeloutputer(1), 50);
});
tooltiplabel[2].addEventListener("mouseenter", () => {
	setTimeout(() => labeloutputer(2), 50);
});
tooltiplabel[0].addEventListener("mouseleave", () => {
	setTimeout(() => labelremoveoutputer(0), 50);
});
tooltiplabel[1].addEventListener("mouseleave", () => {
	setTimeout(() => labelremoveoutputer(1), 50);
});
tooltiplabel[2].addEventListener("mouseleave", () => {
	setTimeout(() => labelremoveoutputer(2), 50);
});

// Set css and add it to <head>
const tooltiplabelwindowcss = `.tooltip-labelwindow {
	border-radius: 5px;
	border: 1px solid #e3e3e3;
	box-shadow: 2px 2px 6px -4px #999;
	cursor: default;
	font-size: 14px;
	left: 62px;
	opacity: 0;
	pointer-events: none;
	position: absolute;
	top: 20px;
	display: flex;
	flex-direction: column;
	overflow: hidden;
	white-space: nowrap;
	z-index: 12;
	transition: 0.15s ease all;
    background: rgba(255,255,255,.96);
}

}
`;
var styleTag = document.createElement("style");
styleTag.innerHTML = tooltiplabelwindowcss;

document.head.appendChild(styleTag);

// Creat a element to display label's window.
var tooltiplabelwindow = [
	document.createElement("div"),
	document.createElement("div"),
	document.createElement("div"),
];

// Add into element.
const bodyadd = document.querySelector("body");
bodyadd.appendChild(tooltiplabelwindow[0]);
bodyadd.appendChild(tooltiplabelwindow[1]);
bodyadd.appendChild(tooltiplabelwindow[2]);

// Add class, content, etc.
tooltiplabelwindow[0].innerText = JSON.stringify(sensor11[0], null, 2);
tooltiplabelwindow[1].innerText = sensor12;
tooltiplabelwindow[2].innerText = JSON.stringify(sensor13[0], null, 2);
tooltiplabelwindow[0].className = "tooltip-labelwindow";
tooltiplabelwindow[1].className = "tooltip-labelwindow";
tooltiplabelwindow[2].className = "tooltip-labelwindow";
console.log(tooltiplabelwindow[0]);
console.log(tooltiplabelwindow[1]);
console.log(tooltiplabelwindow[2]);
