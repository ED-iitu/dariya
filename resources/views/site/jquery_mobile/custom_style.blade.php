<style type="text/css">
    #page-content {
        font-family: 'PT Sans', sans-serif;
        text-shadow: none;
    }

    /*#settingPanel-popup {*/
    /*    width: 80%;*/
    /*    left: 10%;*/
    /*    right: 10%*/
    /*}*/
    #settingPanel.ui-panel {
        width: 15em;
    }
    #barsPanel-popup {
        width: 90%;
        left: 5%;
        right: 5%;
    }

    .ui-tabs {
        height: 500px;
    }

    .ui-tabs-panel {
        height: 80%;
        overflow-y: auto !important;
        padding: 16px 0px;
    }

    .sharing {
        font-size: 18px;
        color: #fff;
        border-radius: 5px;
        background: rgba(0, 0, 0, .8);
        position: absolute;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
        z-index: 10;
        display:none;
        text-shadow: none;
    }
    .sharing--shown{
        display:block;
    }
    .sharing_animate {
        transition: top 75ms ease-out, left 75ms ease-out;
    }

    .social-share {
        width: 100%;
        padding: 0;
        margin: 10px;
        margin-top: 14px;
    }

    .social-share li {
        display: inline;
        padding: 10px;
    }

    .caret {
        border-style: solid;
        border-width: 10px 10px 0px 10px;
        border-bottom-color: transparent;
        border-left-color: transparent;
        border-top-color: rgba(0, 0, 0, .8);
        border-right-color: transparent;
        width: 0px;
        height: 0px;
        display: block;
        position: absolute;
        top: 53px;
        left: 45%;
    }
    .ui-icon-bookmark:after {
        background-image: url('data:image/svg+xml;utf8,<svg width="14" height="14" xmlns="http://www.w3.org/2000/svg"><g><title>background</title><rect fill="none" id="canvas_background" height="14" width="14" y="-1" x="-1"/></g><g><title>Layer 1</title><path stroke="null" fill="#ffffff" id="svg_1" d="m360.34926,0l-318.20605,0c-6.57174,0 -11.90633,4.47656 -11.90633,10l0,374.52734c-0.0093,7.50391 4.98113,14.37891 12.92488,17.8086c7.94841,3.42578 17.51068,2.82812 24.76146,-1.55078l133.32302,-80.26953l133.32768,80.26562c7.25542,4.37109 16.80838,4.96484 24.75215,1.53906c7.93911,-3.42578 12.93418,-10.29687 12.93418,-17.79297l0,-374.52734c0,-5.52344 -5.3346,-10 -11.91099,-10zm-11.90633,384.52344l-140.25288,-84.44141c-4.14862,-2.49609 -9.72971,-2.49609 -13.87366,0l-140.25754,84.44531l0,-364.52734l294.38408,0l0,364.52344zm0,0"/></g></svg>');
    }

    .ui-header-fullscreen, .ui-footer-fullscreen {
        opacity: 1;
    }

    .hidden {
        opacity: 0;
        width: 0;
        height: 0;
        transition: opacity 0.5s ease-out,width 0.5s ease 0.5s, height 0.5s ease 0.5s;
    }
    .setting-panel-header {
        height: 12em;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
    }
    .setting-panel-header p{
        background-color: rgba(0,0,0,0.7);
        color: #FFFFFF;
        position: absolute;
        bottom: 0;
        margin: 0;
        padding: 5px 10px;
    }
    @media (min-width: 28em){
        .ui-field-contain>label~[class*=ui-], .ui-field-contain .ui-controlgroup-controls {
            width: 100%;
        }
        .ui-field-contain>label, .ui-field-contain .ui-controlgroup-label, .ui-field-contain>.ui-rangeslider>label {
            width: 100%;
            margin: .5em 2% .5em 0;
        }
    }

</style>
