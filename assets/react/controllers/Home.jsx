import React, { useState } from 'react';

export default function Home({ companies }) {
    let [search, setSearch] = useState('');

    return (
        <div>
            <h2 className="text-blue-500 font-bold text-2xl">Hello React</h2>

            <input type="text" value={search} onChange={(e) => setSearch(e.target.value)} />
            <ul>
                {/* On filtre les companies dont le nom inclut ce qui a été mis dans la recherche (en minuscule) */}
                {companies.filter(company => company.toLowerCase().includes(search.toLowerCase())).map(company => <li>{company}</li>)}
            </ul>
        </div>
    )
}
