<template>
  <div id="editor">
    <mavon-editor
      ref="md"
      style="height: 100%"
      :ishljs="true"
      v-model="mavonValue"
      @change="chang"
      @imgAdd="imgAdd"
      @imgDel="imgDel"
    ></mavon-editor>
    <button @click="uploadImg">统一上传图片</button>
  </div>
</template>
    <script>
// Local Registration
import { mavonEditor } from "mavon-editor";
import "mavon-editor/dist/css/index.css";
//将markdown语法解析成html的插件
import marked from "marked";
export default {
  name: "editor",
  components: {
    mavonEditor
    // or 'mavon-editor': mavonEditor
  },
  data() {
    return {
      mavonValue: "",
      imgList: []
    };
  },
  methods: {
    chang: function() {
      //解析
      console.log(marked(this.mavonValue));
    },
    // 绑定@imgAdd event
    imgAdd(pos, file) {
      // 缓存图片信息
      this.imgList[pos] = file;
      // console.log(pos)
      console.log("添加图片：" + this.imgList[pos]);
    },
    imgDel(pos) {
      delete this.imgList[pos];
      console.log("删除图片：" + this.imgList[pos]);
    },
    uploadImg() {
      // 第一步.将图片上传到服务器（一次性上传）.
      for (var i in this.imgList) {
        console.log("上传图片" + this.imgList[i]);
        //接口提供了一种表示表单数据的键值对的构造方式，经过它的数据可以使用
        //multipart/form-data
        var formdata = new FormData();
        formdata.append("file", this.imgList[i]);

        this.$axios({
          url: "上传图片的后台地址",
          method: "post",
          data: formdata,
          headers: { "Content-Type": "multipart/form-data" }
        }).then(res => {
          // 第二步.将返回的url替换到文本原位置![...](./0) -> ![...](url)
          /**
           * $vm 指为mavonEditor实例，可以通过如下两种方式获取
           * 1. 通过引入对象获取: `import {mavonEditor} from ...` 等方式引入后，`$vm`为`mavonEditor`
           * 2. 通过$refs获取: html声明ref : `<mavon-editor ref=md ></mavon-editor>，`$vm`为 `this.$refs.md`
           */
          console.log(res);
           //pos为在编辑框中对应的位置0。。。，第二个为上传后的url
            this.$refs.md.$img2Url(pos,url)
        });
      }
    }
  }
};
</script>
    <style>
#editor {
  margin: auto;
  width: 80%;
  height: 580px;
}
</style>