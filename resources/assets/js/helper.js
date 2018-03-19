class Helper {

    static getFormResults(form) {
        var formElements = form.elements;
        var formParams = {};
        var dots = 0;
        var elem = null;
        for (var i = 0; i < formElements.length; i += 1) {
            elem = formElements[i];
            switch (elem.type) {
                case 'submit':
                    break;
                case 'radio':
                    if (elem.checked) {
                        dots = elem.name.split(".");
                        if(dots.length > 1) { // item.something
                            var brackets = dots[0].search(/\[[0-9]\]/);
                            if(brackets > -1) { // items[0].something
                                var key = dots[0].substring(0,brackets); // items
                                var index = dots[0][brackets + 1]; // 0
                                if(!formParams.hasOwnProperty(key)) {
                                    formParams[key] = [];
                                }
                                if(!formParams[key].hasOwnProperty(index)) {
                                    formParams[key][index] = {};
                                }
                                formParams[key][index][dots[1]] = elem.value;
                            } else {
                                if(!formParams.hasOwnProperty(dots[0])) {
                                    formParams[dots[0]] = {};
                                }
                                formParams[dots[0]][dots[1]] = elem.value
                            }
                        } else if(elem.name.slice(-2) === '[]') { // array[]
                            let key = elem.name.substring(0,elem.name.length - 2);
                            if(!formParams.hasOwnProperty(key)) {
                                formParams[key] = [];
                            }
                            formParams[key].push(elem.value);
                        } else {
                            formParams[elem.name] = elem.value;
                        }
                    }
                    break;
                case 'checkbox':
                    if (elem.checked) {
                        dots = elem.name.split(".");
                        if(dots.length > 1) {
                            var brackets = dots[0].search(/\[[0-9]\]/);
                            if(brackets > -1) { // items[0].something
                                var key = dots[0].substring(0,brackets); // items
                                var index = dots[0][brackets + 1]; // 0
                                if(!formParams.hasOwnProperty(key)) {
                                    formParams[key] = [];
                                }
                                if(!formParams[key].hasOwnProperty(index)) {
                                    formParams[key][index] = {};
                                }
                                formParams[key][index][dots[1]] = elem.value;
                            } else {
                                if(!formParams.hasOwnProperty(dots[0])) {
                                    formParams[dots[0]] = {};
                                }
                                formParams[dots[0]][dots[1]] = elem.value
                            }
                        } else if(elem.name.slice(-2) === '[]') {
                            let key = elem.name.substring(0,elem.name.length - 2);
                            if(!formParams.hasOwnProperty(key)) {
                                formParams[key] = [];
                            }
                            formParams[key].push(elem.value);
                        } else {
                            formParams[elem.name] = elem.value;
                        }

                    }
                    break;
                case 'text':
                    if(elem.value != ""){
                        dots = elem.name.split(".");
                        if(dots.length > 1) {
                            var brackets = dots[0].search(/\[[0-9]\]/);
                            if(brackets > -1) { // items[0].something
                                var key = dots[0].substring(0,brackets); // items
                                var index = dots[0][brackets + 1]; // 0
                                if(!formParams.hasOwnProperty(key)) {
                                    formParams[key] = [];
                                }
                                if(!formParams[key].hasOwnProperty(index)) {
                                    formParams[key][index] = {};
                                }
                                formParams[key][index][dots[1]] = elem.value;
                            } else {
                                if(!formParams.hasOwnProperty(dots[0])) {
                                    formParams[dots[0]] = {};
                                }
                                formParams[dots[0]][dots[1]] = elem.value
                            }
                        } else if(elem.name.slice(-2) === '[]') {
                            let key = elem.name.substring(0,elem.name.length - 2);
                            if(!formParams.hasOwnProperty(key)) {
                                formParams[key] = [];
                            }
                            formParams[key].push(elem.value);
                        } else {
                            formParams[elem.name] = elem.value;
                        }
                    }
                    break;
                case 'number':
                    if(elem.value != ""){
                        dots = elem.name.split(".");
                        if(dots.length > 1) {
                            var brackets = dots[0].search(/\[[0-9]\]/);
                            if(brackets > -1) { // items[0].something
                                var key = dots[0].substring(0,brackets); // items
                                var index = dots[0][brackets + 1]; // 0
                                if(!formParams.hasOwnProperty(key)) {
                                    formParams[key] = [];
                                }
                                if(!formParams[key].hasOwnProperty(index)) {
                                    formParams[key][index] = {};
                                }
                                formParams[key][index][dots[1]] = elem.value;
                            } else {
                                if(!formParams.hasOwnProperty(dots[0])) {
                                    formParams[dots[0]] = {};
                                }
                                formParams[dots[0]][dots[1]] = elem.value
                            }
                        } else if(elem.name.slice(-2) === '[]') {
                            let key = elem.name.substring(0,elem.name.length - 2);
                            if(!formParams.hasOwnProperty(key)) {
                                formParams[key] = [];
                            }
                            formParams[key].push(elem.value);
                        } else {
                            formParams[elem.name] = elem.value;
                        }
                    }
                    break;
                default:
                    dots = elem.name.split(".");
                    if(dots.length > 1) {
                        var brackets = dots[0].search(/\[[0-9]\]/);
                        if(brackets > -1) { // items[0].something
                            var key = dots[0].substring(0,brackets); // items
                            var index = dots[0][brackets + 1]; // 0
                            if(!formParams.hasOwnProperty(key)) {
                                formParams[key] = [];
                            }
                            if(!formParams[key].hasOwnProperty(index)) {
                                formParams[key][index] = {};
                            }
                            formParams[key][index][dots[1]] = elem.value;
                        } else {
                            if(!formParams.hasOwnProperty(dots[0])) {
                                formParams[dots[0]] = {};
                            }
                            formParams[dots[0]][dots[1]] = elem.value
                        }
                    } else if(elem.name.slice(-2) === '[]') {
                        let key = elem.name.substring(0,elem.name.length - 2);
                        if(!formParams.hasOwnProperty(key)) {
                            formParams[key] = [];
                        }
                        formParams[key].push(elem.value);
                    } else {
                        formParams[elem.name] = elem.value;
                    }
            }
        }


        return formParams;

    }

    static encodeQueryData(data) {
        let ret = [];
        for (let d in data) {
            if(data[d] != "") {
                ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
            }
        }
        return ret.join('&');
    }

    static startLoading() {
        $("#loader").removeClass("hidden");
    }

    static endLoading() {
        $("#loader").addClass("hidden");
    }
}

export default Helper;
