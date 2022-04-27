let block_image = document.getElementById('block_image');
let btn_add_text_field = document.getElementById('btn_add_text_field');

let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');
canvas.onmousedown = myDown;
canvas.onmouseup = myUp;
canvas.onmousemove = myMove;

let image_src = document.getElementById('image').src;

let fields = [];

let dragok = false;
let startX;
let startY;
let offsetX = 10;
let offsetY = 10;
let num = 0;


let image = new Image();
image.src = image_src;

canvas.width = image.naturalWidth;
canvas.height = image.naturalHeight;

block_image.style.width = image.naturalWidth + 'px';
block_image.style.height = image.naturalHeight + 'px';

draw();

function text() {
    let text = prompt('Введите тект');
    let span = document.createElement('span');

    span.style.position = 'absolute';
    span.style.fontSize = '24pt';

    span.textContent = text;
    document.body.append(span);

    let params = {
        width: span.offsetWidth,
        height: span.offsetHeight,
    }

    span.remove();

    return params;
}

btn_add_text_field.onclick = () => {
    let params = text();

    console.log(params);

    fields.push({
        x: 30,
        y: 100,
        z: 0,
        width: params.width + (params.width * 0.2),
        height: params.height,
        isDragging: false,
        text: text,
    });

    draw();
}

function myUp(e) {
    dragok = false;

    for (let i = 0; i < fields.length; i++) {
        fields[i].isDragging = false;
    }
}

function myMove(e) {
    if (dragok) {
        let mx = parseInt(e.offsetX);
        let my = parseInt(e.offsetY);

        let dx = mx - startX;
        let dy = my - startY;

        for (let i = 0; i < fields.length; i++) {
            if (fields[i].isDragging == true) {
                fields[i].x += dx;
                fields[i].y += dy;
            }
        }

        draw();

        startX = mx;
        startY = my;
    }
}

function myDown(e) {
    let mx = parseInt(e.offsetX);
    let my = parseInt(e.offsetY);
    let group = [];

    dragok = true;

    for (let i = 0; i < fields.length; i++) {
        if (mx > fields[i].x
            && mx < fields[i].x + fields[i].width
            && my > fields[i].y
            && my < fields[i].y + fields[i].height
        ) {
            group.push(fields[i]);
        }
    }


    if (group.length === 1) {
        group[0].isDragging = true;
    } else if (group.length >= 2) {
        let maxZ = group[0].z;
        let b = group[0];

        for (let i = 1; i < group.length; i++) {
            if (maxZ < group[i].z) {
                maxZ = group[i].z;
                b = group[i];
            }
        }
        b.isDragging = true;
    }

    startX = mx;
    startY = my;
}


function rect(field) {
    ctx.fillStyle = '#22222226';
    ctx.fillRect(field.x, field.y, field.width, field.height);

    ctx.fillStyle = "#222";
    ctx.font = "24pt Verdana";
    ctx.fillText(field.text, field.x, (field.y + field.height / 2));
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.drawImage(image, 0, 0);

    // Добавление полей ввода текста
    fields.forEach((field) => {
        rect(field);
    });

    image.onerror = function () {
        console.log('Ошибка загрузки картинки.');
    }
}

