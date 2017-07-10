CKEDITOR.editorConfig = (config) ->
  config.font_names =
    '楷體/Georgia, "標楷體", BiauKai, DFKai-SB, "华文楷体", stkaiti, "楷體", KaiTi, "楷体", SimKai, serif;' +
      '明體/"Times New Roman", Times, "細明體", MingLiU, "新細明體", PMingLiU, serif;' +
      '宋體/"Times New Roman", Times, "儷宋 Pro", "LiSong Pro", "細宋體", SimSun, "新宋體", "宋体", NSimSun, serif;' +
      '黑體/Arial, Helvetica, "儷黑 Pro", "LiHei Pro", "微軟正黑體", "Microsoft JhengHei", "黑體", "黑体", SimHei, sans-serif;' +
      CKEDITOR.config.font_names
  true