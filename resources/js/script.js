let picturesArray = [];


document.getElementById('pictures').onchange = sendAjaxRequests;
function sendAjaxRequests()
{

    let picturesArray = document.getElementById('pictures').files;

    let csrf = document.getElementsByName('_token')[0].value;

    if (picturesArray.length > 10)
    {
        setMessage('You can upload up to 10 files at once');
        return;
    }

    for (let i = 0; i < picturesArray.length; i++)
    {
        const formData = new FormData();
        formData.append("picture", picturesArray[i]);
        formData.append('_token', csrf);
        fetch("/",{
            method: "POST",
            body: formData,
            headers: {
                "Accept": "application/json",
            },
        }).then(imageEncodingCallback, errorCallback);
    }
}

function errorCallback()
{
    setMessage("Server is not responding");
}

async function imageEncodingCallback(response)
{
    let res = await response.json();
    const container = document.getElementById('resultsContainer');

    let template;
    if (res['errors']) //error
        template = document.getElementById('errorItemTemplate');

    else //success
        template = document.getElementById('resultItemTemplate');

    const clone = template.content.cloneNode(true);

    clone.querySelector('.fileName').textContent = res.fileName;
    clone.querySelector('.fileSize').textContent = res.fileSizeBytes / 1000 + ' KB';

    if (res['errors'])
    {
        clone.querySelector('.status').textContent = 'Error';
        clone.querySelector('.message').textContent = res.errors.picture[0];
    }
    else
    {
        let length = picturesArray.push(res);
        clone.querySelector('.status').textContent = 'Success';
        clone.querySelector('.convertedFileSize').textContent = res.encodedFileSizeBytes / 1000 + ' KB';
        clone.querySelector('.copyToClipBtn').onclick = async function() { await copyToClipboard(length - 1, '',''); };
        clone.querySelector('.copyToClipImgBtn').onclick = async function() { await copyToClipboard(length - 1, 'data:image/png;base64,',''); };
        clone.querySelector('.copyToClipCssBtn').onclick = async function() { await copyToClipboard(length - 1,'url(\'data:image/png;base64,','\')'); };
    }

    container.appendChild(clone);

    //console.log(picturesArray);
}

async function copyToClipboard(id, prefix, postfix)
{
    await navigator.clipboard.writeText(prefix + picturesArray[id].base64 + postfix);
}

function setMessage(text)
{
    const container = document.getElementById('messageContainer');
    let toDelete = container.getElementsByClassName('alert');

    if (toDelete.length > 0)
        toDelete[0].remove();

    const messageText = text;
    const message = document.createElement('div');
    message.className = 'alert alert-danger alert-dismissible fade show';
    message.innerHTML = `${messageText}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
    container.appendChild(message);
}
