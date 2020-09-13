<template>
  <form class="form" method="POST" enctype="multipart/form-data">
    <div class="alert alert-success" v-if="isSuccess">
      <span v-text="successMessage"></span>
    </div>

    <div class="alert alert-danger" v-if="hasError">
      <span v-text="errorMessage"></span>
    </div>
    <div class="mb-4">
      <input
        class="form-control"
        name="cinwaanka_casharka"
        type="text"
        placeholder="Cinwaanka casharka"
        v-model="Lesson.cinwaankaCasharka"
      />
    </div>
    <div class="mb-4">
      <label for>Numberka casharka</label>
      <input
        class="form-control"
        name="numbarka_casharka"
        type="number"
        placeholder="Numberka casharka"
        v-model="lessonNumber"
      />
    </div>
    <div class="mb-4">
      <label for>Fileka Casharka</label>
      <input
        class="form-control"
        :name="'file_'+Lesson.filename"
        id="fileka_casharka"
        type="file"
        :ref="'fileka_casharka'"
        placeholder="Numberka casharka"
      />
    </div>
    <div class="mb-4">
      <button
        class="form-control btn btn-primary"
        type="submit"
        :disabled="isLoading"
        @click.prevent="submitForm"
      >
        <span v-text="buttonText"></span>
        <span class="spinner-border text-white small" role="status" v-if="isLoading"></span>
      </button>
    </div>
  </form>
</template>
<script>
export default {
  data() {
    return {
      name: "new lesson form",
      version: 1,
      isLoading: false,
      buttonText: "Add Lesson",
      lessonNumber: 0,
      isSuccess: false,
      successMessage: null,
      hasError: false,
      errorMessage: null
    };
  },
  mounted() {
    if (window.lessonNumber != undefined && window.lessonNumber != null) {
      console.log("I am " + window.lessonNumber);
      this.lessonNumber = window.lessonNumber;
      window.lessonNumber = parseInt(window.lessonNumber) + 1;
      this.Lesson.setCasharNumber(this.lessonNumber);
    }
  },
  methods: {
    resetMessages() {
      this.errorMessage = null;
      this.hasError = false;
      this.isSuccess = false;
      this.successMessage = null;
    },
    submitForm($event) {
      if (
        this.Lesson.cinwaankaCasharka == null ||
        this.Lesson.cinwaankaCasharka.length <= 5
      ) {
        alert(
          "Cinwaanka casharka waa muhiim waa inaad qorto ama kabadan yahay 5 xaraf"
        );
        return;
      }
      this.resetMessages();
      this.buttonText = "Loading...";
      this.isLoading = true;
      var data = new FormData();
      data.append("cinwaanka_casharka", this.Lesson.cinwaankaCasharka);
      data.append("numbarka_casharka", this.lessonNumber);
      // var cfiles = document.getElementById("file_" + this.Lesson.filename)
      var cfiles = this.$refs.fileka_casharka.files[0];
      data.append("fileka_casharka", cfiles);
      data.append("api_token", window.api_token);
      console.log(data);
      var _this = this;
      var config = {
        onUploadProgress: function(progressEvent) {
          var percentCompleted = Math.round(
            (progressEvent.loaded * 100) / progressEvent.total
          );
          _this.buttonText = "loading... " + percentCompleted + "%";
        }
      };

      axios
        .post("/api/lesson/new/" + window.bookId, data, config)
        .then(function(res) {
          if (res.data["isSuccess"] == false) {
            _this.errorMessage = JSON.stringify(res.data["errorMessage"]);
            _this.hasError = true;
            _this.isLoading = false;
            _this.buttonText = "Add Sermon";
          } else {
            _this.successMessage = "successfully completed lesson";
            _this.isSuccess = true;
            _this.$emit("completed-lesson");
            _this.buttonText = "Add Lesson";
            _this.isLoading = false;
            _this.Lesson.cinwaankaCasharka = "";
            _this.Lesson.fileKaCasharka = null;
          }
        })
        .catch(function(err) {
          _this.errorMessage = err.message;
          _this.hasError = true;
          _this.isLoading = false;
          _this.buttonText = "Add Sermon";
        });
    }
  },
  props: ["Lesson"]
};
</script>
