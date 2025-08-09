// Set order information in legacy DOM elements
export const setOrderState = (id, status) => {
  const orderId = document.getElementById("order-id");
  const orderStatus = document.getElementById("order-status");

  if (orderId) orderId.innerHTML = id;
  if (orderStatus) orderStatus.innerHTML = status;
};

// Handle visibility of loading spinner/content
export const loadingData = ({ loading, error }) => {
  const content = document.getElementById("loading-content");
  const spinner = document.getElementById("loading-spinner");

  if (!content || !spinner) return;

  if (error) {
    spinner.style.display = "none";
    content.style.display = "none";
  } else if (loading) {
    spinner.style.display = "block";
    content.style.display = "none";
  } else {
    spinner.style.display = "none";
    content.style.display = "block";
  }
};

// Show notification message in a designated notification panel
export const addNotification = (notification) => {
  const notificationPanel = document.getElementById("notifications");

  if (notificationPanel) {
    notificationPanel.style.display = "block";
    notificationPanel.innerHTML = `<span>${notification}</span>`;
  }
};

// Show a modal popup with a title and message
export const addModalNotification = (title, notification) => {
  const overlay = document.getElementById("overlay");
  const popupContent = document.getElementById("popup-content");

  if (overlay && popupContent) {
    overlay.style.display = "flex";
    popupContent.innerHTML = `<h2>${title}</h2><span>${notification}</span>`;
  }
};

// Static product data
export const staticProduct = {
  currency: "USD",
  amount: 57,
  name: "Rounded Glasses",
};

// Activate sidebar category highlighting
document.addEventListener("DOMContentLoaded", () => {
  const categoryElements = document.querySelectorAll(".sidebar .category");

  categoryElements.forEach((category) => {
    category.addEventListener("click", () => {
      category.classList.toggle("active");
    });
  });

  // Close modal if buttons are present
  const closeModal = () => {
    const overlay = document.getElementById("overlay");
    if (overlay) overlay.style.display = "none";
  };

  const modalCloseButton = document.getElementById("close-btn");
  const modalDoneButton = document.getElementById("done-btn");

  if (modalCloseButton) {
    modalCloseButton.addEventListener("click", closeModal);
  }

  if (modalDoneButton) {
    modalDoneButton.addEventListener("click", closeModal);
  }
});
