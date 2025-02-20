var sound_value = 0;
const num_bars = 10;
const height_mini = 20;
const height_max = 180;
const height_factors = [0.5, 1, 1.5, 2, 1, 0.75, 0.5, 2.25, 1, 0.5];

function randomIntFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

async function updateSoundValue() {
    sound_value = await getMeasure() || 0;
    $('#id_dB_live').text(`${sound_value}db`);
    return sound_value;
}

async function Anim() {
    let heights = [];

    for (let i = 0; i < num_bars; i++) {
        let random_anim = randomIntFromInterval(80, 120);
        let height = height_factors[i] * sound_value * (random_anim / 100);
        height = Math.min(Math.max(height, height_mini), height_max);
        heights.push(height);
    }

    for (let i = 0; i < num_bars; i++) {
        anime({
            targets: `.Snd_bar_${i + 1}`,
            height: heights[i],
            easing: 'linear',
            loop: false,
            duration: 100
        });
    }
}

$(document).ready(async function() {
    await updateSoundValue();
});

setInterval(updateSoundValue, 1000);

setInterval(Anim, 100);