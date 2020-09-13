export default class Lesson {

    constructor() {
        this.casharId = -1;
        this.cinwaankaCasharka = null;
        this.sheekhId = -1;
        this.bookId = -1;
        this.numberkaCasharka = -1;
        this.fileKaCasharka = null;
        this.filename = Date.now() + 'df' + Math.round(Math.random() * 1000);

        this.hasError = false;
        this.errorMessage = null;
        this.isSuccess = false;
        this.successMessage = null;

    }

    setCasharNumber(number) {
        this.numberkaCasharka = number;
    }
}