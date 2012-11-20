function formatTime(time) {
				var min = Math.floor(time/60000);
				var sec = Math.floor(time / 1000) - (min * 60);
				sec = ("0" + sec).slice(-2);
				var milli = time - (min * 60000) - (sec * 1000);
				milli = ("000" + milli).slice(-4);
				return (min + ":" + sec + ":" + milli);

			}

			function unformatTime(time) {
				var rawTime = 0;
				var bits = time.split(":");
				//console.log(bits.toString());
				rawTime += 3600000 * bits[0];
				rawTime += 60000 * bits[1];
				rawTime += 1000 * bits[2];
				return rawTime;
			}