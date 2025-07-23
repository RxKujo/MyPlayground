document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('ville_input');
  const hidden = document.getElementById('ville_id');
  const suggestions = document.getElementById('ville_suggestions');

  input.addEventListener('input', async () => {
    const query = input.value;
    if (query.length < 2) {
      suggestions.innerHTML = '';
      return;
    }

    const response = await fetch('/api/cities?q=' + encodeURIComponent(query));
    const data = await response.json();
    suggestions.innerHTML = '';

    (data.cities || []).forEach(city => {
      const item = document.createElement('div');
      item.className = 'list-group-item list-group-item-action';
      item.textContent = `${city.ville} (${city.code_postal})`;
      item.addEventListener('click', () => {
        input.value = `${city.ville} (${city.code_postal})`;
        hidden.value = city.id;
        suggestions.innerHTML = '';
      });
      suggestions.appendChild(item);
    });
  });

  document.addEventListener('click', (e) => {
    if (!suggestions.contains(e.target) && e.target !== input) {
      suggestions.innerHTML = '';
    }
  });
});
