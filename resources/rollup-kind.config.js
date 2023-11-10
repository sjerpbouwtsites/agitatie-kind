const path = require('path');
const fs = require('fs');
const scss = require("rollup-plugin-scss");

const uncompiled = path.resolve(`${__dirname}/uncompiled`);
const build = path.resolve(`${__dirname}/build`);
const thema = path.resolve(`${__dirname}/../`);

module.exports = {
  input: `${uncompiled}/js/index.js`,
  output: {
    file: `${build}/js/kind-bundel.js`,
    format: "es",
  },
  plugins: [
    scss({
      watch: [
        `${uncompiled}/stijl/`,
        `${uncompiled}/stijl/**/*`,
        `${uncompiled}/stijl/style.scss`,
      ],
      output: function (styles, styleNodes) {
        fs.writeFileSync("style.css", styles);
      },
      sourceMaps: true,
      outFile: "../style.css",
    }), // will output compiled styles to output.css
  ],
};