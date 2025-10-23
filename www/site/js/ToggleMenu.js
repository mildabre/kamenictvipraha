class ToggleMenu
{
    #containerSelector = '.toggle-menu'
    #bottomContainerClass = 'toggle-menu-bottom'
    #bodySelector = '.toggle-menu-body'
    #bodyExpandedClass = 'toggle-menu-expanded'
    #bodyCollapsedClass = 'toggle-menu-collapsed'
    #collapsedKey = 'collapsed'
    #togglerSelector = '.toggle-menu-toggler'
    #togglerCollapseClass = 'toggle-menu-toggler-collapse'
    #togglerHiddenClass = 'toggle-menu-toggler-hidden'

    constructor() {
        document.addEventListener('DOMContentLoaded', () => {
            document.addEventListener('click', event => this.#handleClick(event))
            this.#initialize()
        })
    }

    #initialize() {
        document.querySelectorAll(this.#containerSelector).forEach(container => {
            let toggler = container.querySelector(this.#togglerSelector)
            if (toggler) {
                toggler.classList.remove(this.#togglerHiddenClass)
            }
            this.#initializeState(container)
            this.#applyVisualState(container)
        })
    }

    #handleClick(event) {
        let toggler = event.target.closest(this.#togglerSelector)
        if (!toggler) return
        let container = toggler.closest(this.#containerSelector)
        if (container) {
            this.#toggleState(container)
            this.#applyVisualState(container, true)
        }
    }

    #applyVisualState(container, firedByClick = false) {
        let collapsed = this.#isCollapsed(container)
        let fixBottom = firedByClick && container && container.classList.contains(this.#bottomContainerClass)
        let bottom = container?.getBoundingClientRect().bottom

        let body = container.querySelector(this.#bodySelector)
        if (body) {
            body.classList.toggle(this.#bodyCollapsedClass, collapsed)
            body.classList.toggle(this.#bodyExpandedClass, !collapsed)
        }

        let toggler = container.querySelector(this.#togglerSelector)
        if (toggler) {
            toggler.classList.toggle(this.#togglerCollapseClass, !collapsed)
        }

        if (fixBottom) {
            let finalBottom = container.getBoundingClientRect().bottom
            window.scrollBy({ top: finalBottom - bottom })
        }
        window.dispatchEvent(new CustomEvent('layout:changed'))
    }

    #initializeState(container) {
        let collapsed = container.hasAttribute('data-' + this.#collapsedKey)
        container.dataset[this.#collapsedKey] = collapsed ? 'true' : 'false'
    }

    #toggleState(container) {
        container.dataset[this.#collapsedKey] = this.#isCollapsed(container) ? 'false' : 'true'
    }

    #isCollapsed(container) {
        return container.dataset[this.#collapsedKey] === 'true'
    }
}

new ToggleMenu()