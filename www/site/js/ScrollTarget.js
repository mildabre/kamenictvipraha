class ScrollTarget
{
    #topMenuSelector = '.toggle-menu-top'
    #bottomMenuSelector = '.toggle-menu-bottom'
    #isStaticScrollAllowed = true;
    #topMarginOffset = 2;
    #maxTopMargin = 23                // px

    #sideTargetSuffix = '-side'
    #topTargetSuffix = '-top'
    #bottomTargetSuffix = '-bottom'
    #staticTargetSuffix = '-static'
    #standbyTimeout = 50                    //  on desktop 30 ms DOMContentLoaded + 10 ms first frame

    constructor() {
        document.addEventListener('DOMContentLoaded', () => this.#initialize())
        document.addEventListener('scroll', () => this.#staticScroll())
        document.addEventListener('click', event => this.#dynamicScroll(event))
    }

    #initialize() {
        this.#resolveStaticScrollTarget()
        requestAnimationFrame(() => setTimeout(() => this.#isStaticScrollAllowed = false, this.#standbyTimeout))
    }

    #resolveStaticScrollTarget() {
        let currentHash = window.location.hash.slice(1)
        if (!currentHash) return

        let scrollTarget = this.#searchTargetByHash(currentHash, true)
        let staticTarget = document.getElementById(currentHash)
        let substituteTarget = scrollTarget && scrollTarget !== staticTarget
        if (substituteTarget) {
            if (staticTarget) staticTarget.removeAttribute('id')
            if (!scrollTarget.id) scrollTarget.id = currentHash
        }
    }

    #dynamicScroll(event) {
        let link = event.target.closest('a');
        if (!link) return;
        let menuClick = link.closest(this.#topMenuSelector) || link.closest(this.#bottomMenuSelector)
        if (!menuClick) return

        let topMenuClick = Boolean(link.closest(this.#topMenuSelector))
        let target = this.#searchTargetByLink(link, topMenuClick);
        if (target) {
            event.preventDefault();
            this.#scrollToElement(target);
        }
    }

    #searchTargetByLink(link, topMenuClick) {
        let linkUrl = new URL(link.href)
        let linkHash = linkUrl.hash.slice(1)
        linkUrl.hash = ''

        let currentUrl = new URL(window.location.href)
        currentUrl.hash = ''

        let isLocalAnchorClick = linkHash && linkUrl.href === currentUrl.href
        if (isLocalAnchorClick) {
            return this.#searchTargetByHash(linkHash, topMenuClick)
        }

        return null
    }

    #searchTargetByHash(hash, topMenuClick = true) {
        return  this.#getTargetCandidates(hash, topMenuClick).find(candidate => this.#resolveCandidate(candidate, hash))
    }

    #getTargetCandidates(hash, topMenuClick) {
        let side = document.querySelector(this.#getSelector(hash, this.#sideTargetSuffix))
        let top = document.querySelector(this.#getSelector(hash, this.#topTargetSuffix))
        let bottom = document.querySelector(this.#getSelector(hash, this.#bottomTargetSuffix))
        let stat = document.querySelector(this.#getSelector(hash, this.#staticTargetSuffix))
        let candidates = topMenuClick ? [side, top, bottom, stat] : [bottom, side, top, stat]

        return candidates.filter(Boolean)
    }

    #getSelector(hash, suffix) {
        return '[data-target-' + hash + suffix + ']'
    }

    #resolveCandidate(candidate, hash) {
        if (getComputedStyle(candidate).display === 'none') return false
        if (getComputedStyle(candidate.parentElement)?.display === 'none') return false
        if (getComputedStyle(candidate.parentElement.parentElement)?.display === 'none') return false

        return !candidate.id || candidate.id === hash
    }

    #staticScroll() {
        if (!this.#isStaticScrollAllowed) return

        this.#isStaticScrollAllowed = false
        let currentHash = window.location.hash.slice(1)
        if (!currentHash) return

        let target = this.#searchTargetByHash(currentHash, true)
        if (target) {
            if (!this.#isStaticTarget(target, currentHash)) {
                scrollTo({ top: 0 })
                this.#scrollToElement(target)

            } else {
                let offset = - this.#getTopMargin(target)
                scrollBy({ top: offset })
            }
            window.history.replaceState(null, '', window.location.origin + window.location.pathname)
        }
    }

    #isStaticTarget(target, currentHash) {
        let bottom = document.querySelector(this.#getSelector(currentHash, this.#bottomTargetSuffix))
        let stat = document.querySelector(this.#getSelector(currentHash, this.#staticTargetSuffix))
        return target === bottom || target === stat
    }

    #scrollToElement(element) {
        let elementOffsetY = Math.floor(window.scrollY + element.getBoundingClientRect().top)
        let top = elementOffsetY - this.#getTopMargin(element)
        scrollTo({ top: top, behavior: "smooth" })
    }

    #getTopMargin(element) {
        let targetStyle = getComputedStyle(element)

        if (targetStyle.float  === 'left' || targetStyle.float === 'right') {
            return -this.#topMarginOffset
        }

        let topMarginParent = (parseInt(targetStyle.marginTop) || 0) - this.#topMarginOffset

        let firstChild = element.firstElementChild
        let topMarginChild = firstChild ? getComputedStyle(firstChild).marginTop : 0
        topMarginChild = (parseInt(topMarginChild) || 0) - this.#topMarginOffset

        let topMargin = Math.max(topMarginParent, topMarginChild)
        return Math.min(Math.max(topMargin, 0), this.#maxTopMargin)
    }
}

new ScrollTarget()