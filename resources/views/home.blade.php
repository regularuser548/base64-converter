<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Image to Base64 Converter</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    </head>
    <body class="d-flex flex-column min-vh-100">


    <!--result item templates-->
    <template id="resultItemTemplate">
        <div class="resultItem d-flex justify-content-between m-1 p-2 bg-success text-dark bg-opacity-25 border border-secondary rounded">
            <span class="fileName fw-bold w-25 ms-2 me-2 text-break"></span>
            <span class="fileSize ms-2 me-2"></span>
            <span class="status ms-2 me-2"></span>
            <span class="convertedFileSize ms-2 me-2"></span>
            <div>
                <button class="copyToClipBtn btn btn-light btn-sm" data-picId="">Copy</button>
                <button class="copyToClipImgBtn btn btn-light btn-sm" data-picId="">Copy for img</button>
                <button class="copyToClipCssBtn btn btn-light btn-sm" data-picId="">Copy for css</button>
            </div>
        </div>
    </template>

    <template id="errorItemTemplate">
        <div class="errorItem d-flex justify-content-between m-1 p-2 bg-danger text-dark bg-opacity-25 border border-secondary rounded">
            <span class="fileName fw-bold w-25 ms-2 me-2 text-break"></span>
            <span class="fileSize ms-2 me-2"></span>
            <span class="status ms-2 me-2"></span>
            <span class="message text-wrap"></span>
            <div></div>
        </div>
    </template>

    <!--header-->
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none ms-5">
            <span class="fs-4">Base64 Converter</span>
        </a>

        <div class="me-5">
           <button id="encodeBtn" class="btn btn-primary">Encode</button>
           <button id="decodeBtn" class="btn btn-secondary">Decode</button>
        </div>
    </header>

        <div id="encoderContainer" class="container">
            <div class="row">
                <div class="col d-flex justify-content-center flex-wrap">

                    <div class="mb-4">
                        <h2>Convert your images to base64</h2>

                        <!--container for messages-->
                        <div id="messageContainer">

                        </div>

                        <!--form-->
                        <form class="d-flex">
                            @csrf
                            <input id="pictures" name="pictures" type="file" required multiple accept="image/*" class="form-control form-control-lg">
                        </form>
                    </div>

                </div>
            </div>
            <!--results container-->
            <div class="row">
                <div class="col">
                    <div id="resultsContainer" class="rounded p-2 d-none">
                        <!--results table-->
                        <div class="d-flex rounded m-1 p-2 justify-content-between" id="resultsTable">
                            <span class="fw-bold w-25 ms-2 me-2">Filename</span>
                            <span class="fw-bold ms-2 me-2">Size</span>
                            <span class="fw-bold ms-2 me-2">Status</span>
                            <span class="fw-bold ms-2 me-2">Converted</span>
                            <div style="width: 13.5rem;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!--file formats div-->
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <div id="fileFormatsInfo" class="rounded p-3 mt-4 mb-4 d-inline-block">
                        <h3>File Formats</h3>
                        <span>You can upload up to 10 images (max. 1.00 MB each) as JPG, PNG, GIF, WebP, SVG or BMP.</span>
                    </div>
                </div>
            </div>

        </div>

        <div id="decoderContainer" class="container d-none">
            <div class="row">
                <div class="col-6">
                    <button id="clearBtn" class="btn btn-secondary btn-sm mb-1">Clear</button>
                    <label for="decoderInput"></label>
                    <textarea id="decoderInput" class="form-control" rows="15" cols="50" placeholder="Paste your base64 string"></textarea>
                </div>
                <div class="col-6 p-4 d-flex justify-content-center align-items-center">
                    <img id="decoderOutput" class="rounded" src="" alt="Image Preview">
                </div>
            </div>
        </div>

    <!--footer-->
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top mt-auto">
        <div class="col-md-4 d-flex align-items-center ms-5 my-2">
            <span class="mb-3 mb-md-0 text-body-secondary">© 2024 Company, Inc</span>
        </div>
    </footer>

    </body>
</html>
