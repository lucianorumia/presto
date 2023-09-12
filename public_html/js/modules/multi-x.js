const MULTI_X = document.querySelector('.multi-x');

function focusXSlide(multiX, index) {
    index ?
        multiX.style.left = `-${index * 100}vw` :
        multiX.style.left = '0';
};

export {
    MULTI_X,
    focusXSlide
};