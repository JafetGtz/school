const findFirstAlert = () => {
    let alerts = document.querySelectorAll('[role="alert"')
    return [...alerts].find(el => el.style.display !== 'none')
}

export default function (error) {
    console.error(error.response || error)

    if (error.response) {
        const { errors } = error.response.data

        if (errors) {
            setTimeout(() => {
                const el = findFirstAlert()
                document.scrollingElement.scrollTo({
                    top: el ? el.offsetTop : 0,
                    behavior: 'smooth',
                })
            }, 0)
        }
        return errors || {}
    }

    return {}
}
