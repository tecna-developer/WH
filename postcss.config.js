export const plugins = {
  "postcss-pxtorem": {
    rootValue: 16,
    propList: ["*"],
    selectorBlackList: ["ignore-rem"], // Классы, которые нужно игнорировать
    minPixelValue: 2,
    replace: true,
    mediaQuery: false, // Разрешить конвертацию в медиа-запросах?
  },
};
