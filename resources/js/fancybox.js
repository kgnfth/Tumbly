import { Fancybox } from "@fancyapps/ui";
window.Fancybox = Fancybox;

Fancybox.bind("[data-fancybox-plyr]", {
	on: {
        reveal: (fancybox, slide) => {
            if (typeof Plyr === undefined) {
                return;
            }

            let $el;

            if (slide.type === "html5video") {
                $el = slide.$content.querySelector("video");
            } else if (slide.type === "video") {
                $el = document.createElement("div");
                $el.classList.add("plyr__video-embed");

                $el.appendChild(slide.$iframe);

                slide.$content.appendChild($el);
            }

            if ($el) {
                slide.player = new Plyr($el);
            }
			fancybox.$container.style.setProperty(
                "--bg-image",
                `url("${slide.thumb}")`
                );
        },
        "Carousel.unselectSlide": (fancybox, carousel, slide) => {
            if (slide.player) {
                slide.player.pause();
            }
        },
        "Carousel.selectSlide": (fancybox, carousel, slide) => {
            if (slide.player) {
                slide.player.play();
            }
        },
    },
});