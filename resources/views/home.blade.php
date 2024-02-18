<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image to Base64 Converter</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        @vite(['resources/js/app.js'])
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col d-flex justify-content-center flex-wrap">

                    <template id="resultItemTemplate">
                        <div class="resultItem d-flex justify-content-between m-1 p-2 bg-success text-dark bg-opacity-25 border border-secondary rounded">
                            <span class="fileName fw-bold w-25 ms-2 me-2 text-break"></span>
                            <span class="fileSize ms-2 me-2"></span>
                            <span class="status ms-2 me-2"></span>
                            <span class="convertedFileSize ms-2 me-2"></span>
                            <div>
                                <button class="copyToClipBtn btn btn-secondary btn-sm">Copy</button>
                                <button class="copyToClipImgBtn btn btn-secondary btn-sm">Copy for img</button>
                                <button class="copyToClipCssBtn btn btn-secondary btn-sm">Copy for css</button>
                            </div>
                        </div>
                    </template>

                    <template id="errorItemTemplate">
                        <div class="errorItem d-flex justify-content-between m-1 p-2 bg-danger text-dark bg-opacity-25 border border-secondary rounded">
                            <span class="fileName fw-bold w-25 ms-2 me-2 text-break"></span>
                            <span class="fileSize ms-2 me-2"></span>
                            <span class="status ms-2 me-2"></span>
                            <span class="message text-wrap"></span>
                        </div>
                    </template>

                    <div class="mb-4">
                        <h2>Convert your images to base64</h2>

                        <div id="messageContainer">

                        </div>

                        <form class="d-flex">
                            @csrf
                            <input id="pictures" name="pictures" type="file" required multiple accept="image/*" class="form-control">
                        </form>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div id="resultsContainer">

                    </div>
                </div>
            </div>

        </div>
    </body>
</html>
