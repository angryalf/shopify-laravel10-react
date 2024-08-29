import React from 'react';
import ReactDOM from 'react-dom';

export default function HelloReactCrm(props) {
    return (
        <h1>Hello CRM React!</h1>
    );
}



ReactDOM.render(<HelloReactCrm name="CRM"/>, document.getElementById('crm-react'));

