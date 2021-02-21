export default class serverRequest {
    constructor(debugMode = true) {
        this.req = null;
        this.error = null;
        this.data = null;
        this.debug_mode = debugMode;
    }
    debugMessage(message1, message2) {
        if (this.debug_mode)
            console.log(message1, message2);
    }
    setRequest(req) {
        this.debugMessage('will set request ', req);
        this.req = req;
    }
    serverRequest(url, successCallback, errorCallback, args = []) {
        //args contains list of functions or additional properties
        //for the successCallback
        axios.post(url, this.req, { headers: { Authorization: `Bearer ${window.token}` } }).
        then(response => {
                response = response.data;
                if (response.hasOwnProperty('error_message')) {
                    this.debugMessage('server error ', response.error_message);
                    this.error = response.error_message;
                    errorCallback(this.error);
                    return false;
                } else if (response.isSuccess) {
                    this.debugMessage('success request ', response);
                    this.data = response.data;
                    successCallback(this.data, args);
                    return true;
                } else {
                    this.debugMessage('error reposen ', response);
                    this.error = response.errorMessage;
                    errorCallback(this.error);
                    return false;
                }
            })
            .catch(error => {
                this.debugMessage("server error ", error);
                errorCallback(error);
            })
    }
    previewFile(input, successCallback, errorCallback) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = (e) => {
                successCallback(e);
            }
            reader.onerror = (error) => {
                errorCallback(error);
            }
            reader.onabort = (interupt) => {
                errorCallback(interupt);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    getError() {
        return this.error;
    }
    getData() {
        return this.data;
    }
}