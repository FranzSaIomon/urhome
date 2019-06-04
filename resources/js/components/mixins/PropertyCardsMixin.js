export default {
    data: {
        cards: [],
        bottom: false,
        searchable: null,
        resultCount: 0,
        loading: false
    },
    created() {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY
            const visible = document.documentElement.clientHeight
            const pageHeight = document.documentElement.scrollHeight
            const bottomOfPage = visible + scrollY >= pageHeight
            this.bottom = bottomOfPage || pageHeight < visible
        })
    },
    watch: {
        bottom(bottom) {
            if (bottom && this.searchable) {
                this.searchable.search()
            }
        }
    }
}