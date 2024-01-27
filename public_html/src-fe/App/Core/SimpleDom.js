export default class SimpleDom {
    static createElement(tag, attributes, children) {
        const element = document.createElement(tag);

        if (attributes) {
            for (const [key, value] of Object.entries(attributes)) {
                element.setAttribute(key, value);
            }
        }

        if (children) {
            if (Array.isArray(children)) {
                children.forEach(child => {
                    if (typeof child === 'string') {
                        element.appendChild(document.createTextNode(child));
                    } else {
                        element.appendChild(child);
                    }
                });
            } else {
                if (typeof children === 'string') {
                    element.appendChild(document.createTextNode(children));
                } else {
                    element.appendChild(children);
                }
            }
        }

        return element;
    }

    static render(element, container) {
        container.appendChild(element);
    }
}
