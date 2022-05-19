let block_image = document.getElementById('block_image');
let btn_add_text_field = document.getElementById('btn_add_text_field');
let btn_save_image = document.getElementById('btn_save_image');

let btn_exel_file = document.getElementById('btn_exel_file');
let field_exel_file = document.getElementById('field_exel_file');
let csrf_token = document.getElementsByName('csrf-token');
let table = document.getElementById('table');

let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');
canvas.onmousedown = myDown;
canvas.onmouseup = myUp;
canvas.onmousemove = myMove;

let image_src = document.getElementById('image').src;

let fields = [];
let exelData = [];

// Настройки шрифта
let font = {
    size: 24,
    title: 'Verdana',
}

let dragok = false;
let startX;
let startY;
let offsetX = 10;
let offsetY = 10;
let num = 0;

// Парсинг файла

// Сделать кнопку активной после выбора файла
field_exel_file.onchange = () => {
    btn_exel_file.disabled = false;
}

btn_enter_data.onclick = async () => {
    let string = 0;

    if (fields.length === 0) {
        return false;
    }

    let timer = setInterval(async () => {
        if (string >= exelData.length) {
                clearInterval(timer);
                return true;
        }

        for (let f = 0; f < fields.length; f++) {
            fields[f].text = exelData[string][f];
        }

        rectAll();
        draw();
        // saveCanvasAsImageFile();

        string++;
    }, 1000);
}

function checkField(id) {
    let flag = false;

    fields.forEach((field) => {
        if (field.id === id) {
            flag = true;
        }
    });

    return flag;
}

function create_list_fields(id) {
    let list_fields = document.getElementById('list_fields');
    let btn_enter_data = document.getElementById('btn_enter_data');

    let li = document.createElement('li');
    let btn = document.createElement('button');

    btn.className = 'btn btn-link';
    btn.textContent = 'Разместить';
    li.className = 'list-group-item';
    li.textContent = 'Поле ' + id;

    li.append(btn);

    btn.addEventListener('click', () => {
        if (!checkField(id)) { // Если поле не было добавлено ранее
            fields.push({
                x: 30,
                y: 100,
                z: 0,
                width: 100,
                height: 75,
                isDragging: false,
                text: 'Поле ' + id,
                id: id,
            });

            draw();
            btn_enter_data.disabled = false;
        }
    });

    list_fields.parentElement.hidden = false;

    list_fields.append(li);
}

btn_exel_file.onclick = async () => {
    btn_exel_file.disabled = true;

    let thead = document.createElement('thead');
    let tbody = document.createElement('tbody');
    let tr = document.createElement('tr');

    thead.append(tr);
    table.append(thead, tbody);

    const formData = new FormData();
    formData.append('file', field_exel_file.files[0]);
    formData.append('_csrf', csrf_token[0].content);

    try {
        const response = await fetch('/template/load', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        let res = JSON.parse(JSON.stringify(result));

        if (res['result']) {
            let data = res['data'];

            for (let i = 0; i < data.length; i++) {
                await data[i].shift(); // Удалить номерацию строк
                exelData.push(data[i]);
                let tr = document.createElement('tr');

                for (let j = 0; j < data[i].length; j++) {
                    let td = document.createElement('td');
                    td.append(data[i][j]);
                    tr.append(td);
                }

                tbody.append(tr);
            }

            // Заголовки таблицы
            for (let i = 1; i <= data[0].length; i++) {
                let th = document.createElement('th');
                th.append('Поле ' + i);
                tr.append(th);
                create_list_fields(i); // Список полей для размещения на холсте
            }
        }else {
            alert(res['message'])
        }
    } catch (error) {
        console.error('Ошибка:', error);
    }
}

// Работа с текстом на канвасе
let image = new Image();
image.src = image_src;

canvas.width = image.naturalWidth;
canvas.height = image.naturalHeight;

block_image.style.width = image.naturalWidth + 'px';
block_image.style.height = image.naturalHeight + 'px';

draw();

btn_add_text_field.onclick = () => {
    let params = EnterText();

    fields.push({
        x: 30,
        y: 100,
        z: 0,
        width: params.width + (params.width * 0.2),
        height: params.height,
        isDragging: false,
        text: params.text,
        color: 'rgba(0, 123, 255, 0)',
    });

    draw();
}

function EnterText() {
    return getTextSize(prompt('Введите тект'))
}


// Перемещение поля
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



function getTextSize(text) {
    let span = document.createElement('span');

    span.style.position = 'absolute';
    span.style.fontSize = font.size + 'pt';

    span.textContent = text;
    document.body.append(span);

    let params = {
        width: span.offsetWidth,
        height: span.offsetHeight,
        text: text,
    }

    span.remove();

    return params;
}

function rect(field) {
    ctx.fillStyle = 'rgba(0, 123, 255, 0)';
    ctx.fillRect(field.x, field.y, field.width, field.height);
    ctx.font = font.size + 'pt ' + font.title;
    ctx.fillText(field.text, field.x, (field.y + field.height / 2));
}

function rectAll() {
    ctx.fillStyle = 'rgba(0, 123, 255, 0)';

    fields.forEach((field) => {
        ctx.fillRect(field.x, field.y, field.width, field.height);
        ctx.font = font.size + 'pt ' + font.title;
        ctx.fillText(field.text, field.x, (field.y + field.height / 2));
    });
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



// Сохранение изображения

btn_save_image.onclick = async () => {
    saveCanvasAsImageFile();
}

function getImage(canvas){
    let imageData = canvas.toDataURL();
    let image = new Image();
    image.src = imageData;

    return image;
}

function saveImage(image) {
    let link = document.createElement("a");
    link.setAttribute("href", image.src);
    link.setAttribute("download", "image");
    link.click();
}

function saveCanvasAsImageFile(){
    let image = getImage(document.getElementById("canvas"));
    saveImage(image);
}
