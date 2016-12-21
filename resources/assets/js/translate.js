export default {
    install(vue, dictionary) {
        vue.prototype.$trans = this.trans;
        vue.prototype.$dictionary = dictionary;
    },

    trans (key) {
        if (_.isString(this.$dictionary[key])) {
            return this.$dictionary[key];
        }

        return _.capitalize(_.startCase(key));
    }
}